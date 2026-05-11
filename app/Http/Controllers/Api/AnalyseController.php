<?php

namespace App\Http\Controllers\Api;

use App\Criteria\LimitOffsetCriteria;
use App\Events\AiPerfomEvent;
use App\Http\Controllers\Api\Controller;
use App\Models\Analyse;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Repositories\Interfaces\CreditRepository;
use App\Repositories\Interfaces\CreditTransactionRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

class AnalyseController extends Controller
{

      /** @var AnalyseRepository */
    private AnalyseRepository $analyseRepository;

     /** @var CreditRepository */
    private CreditRepository $creditRepository;

      /** @var CreditTransactionRepository */
    private CreditTransactionRepository $creditTransactionRepository;



    public function __construct(AnalyseRepository $analyseRepo ,
        CreditRepository $creditRepository,
        CreditTransactionRepository $creditTransactionRepository,

    )
    {
        $this->creditRepository = $creditRepository;
        $this->analyseRepository = $analyseRepo;
        $this->creditTransactionRepository = $creditTransactionRepository;

        parent::__construct();
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->validate($request, Analyse::$rules   );

            //enregistrer les detail de l'analyse ou prompt
            $input = $request->all();
            $input['status'] = 'pending';

            // vérifier si user veut full ou pas
            $useCredits = $request->get('use_credits', false);
            if ($useCredits) {

                $cost = 1;

                $credit = $this->creditRepository->findByField('user_email', $email)->first();
                $balance = $credit->remaining_credits ;

                if ($balance < $cost) {
                    return $this->sendError('Not enough credits', 402);
                }

                // déduire crédits
                $this->consumeCredit($email, $cost);

                $input['is_full_unlocked'] = true;

            } else {
                $input['is_full_unlocked'] = false;
            }
            $analyse = $this->analyseRepository->create($input);

            //event senttoperforme AI prompt
            event(new AiPerfomEvent($analyse));


        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()), 422);
        } catch (Exception $e) {
            Log::error("Error storing analyse: " . $e->getMessage());

            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($this->partialResponse($analyse), __('lang.saved_successfully', ['operator' => __('lang.resume')]));

    }


    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $this->analyseRepository->pushCriteria(new RequestCriteria($request));
            $this->analyseRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        $analyse = $this->analyseRepository->find($id);
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }

        // $this->authorize('view', $analyse);


        if ($analyse->is_full_unlocked) {
            return $this->sendResponse(
                $this->fullResponse($analyse),
                'Full result  retrieved successfully'
            );
        }

        return $this->sendResponse(
            $this->partialResponse($analyse),
            'Partial result  retrieved successfully'
        );

    }

    public function showFullResult(int $id, Request $request)
    {
        app('tenant_id') ; // contaitre le tenant à tout moment
        $user = $request->user(); // propre et explicite
        $fullResultprice = 2 ;
        //combien de credit avez vous pour cette action
        //supposon que cette action necessite 2credit
        try {
            $this->analyseRepository->pushCriteria(new RequestCriteria($request));
            $this->analyseRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        $analyse = $this->analyseRepository->find($id);
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }
        // ✅ autorisation APRÈS récupération
        $this->authorize('view', $analyse);

        return $this->sendResponse($this->fullResponse($analyse), 'Analyse retrieved successfully');
    }


    private function partialResponse($analysis)
    {
        return[
            'id' => $analysis->id,
            'status' => $analysis->status,
            'score' => $analysis->score,
            'preview' => substr($analysis->optimized_resume, 0, 200),
            'locked' => true
        ];
    }

    private function fullResponse($analysis)
    {
        [
            'id' => $analysis->id,
            'status' => $analysis->status,

            'score' => $analysis->score,
            'score_breakdown' => $analysis->score_breakdown_json,
            'problems' => $analysis->critical_problems_json,
            'missing_keywords' => $analysis->missing_keywords_json,
            'optimized_resume' => $analysis->optimized_resume,
            'cover_letter' => $analysis->cover_letter,
            'locked' => false
        ];
    }

    private function consumeCredit($email , $credits)
    {
        $credit = $this->creditRepository->findByField('user_email', $email)->first();

        if ($credit->remaining_credits <= 0) {
            throw new Exception('Plus de crédits');
        }

        $newBalance = $credit->remaining_credits - $credits;

        $this->creditRepository->update([
            'remaining_credits' => $newBalance
        ],$credit->id);

        $this->creditTransactionRepository->create([
            'user_email' => $email,
            'type' => 'usage',
            'credits' => - $credits ,
            'balance_after' => $newBalance,
            'description' => 'Full analysis unlock'
        ]);
    }


    public function downloadResume(int $id, Request $request){
        $analyse = $this->analyseRepository->find($id);
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }

        // $this->authorize('view', $analyse);

        // if (!$analyse->is_full_unlocked) {
        //     return $this->sendError('Access denied. Unlock full result first.', 403);
        // }

        $resume = json_decode($analyse->optimized_resume, true);
        if (!$resume) {
            return $this->sendError('Resume data invalid', 500);
        }

        $pdf = Pdf::loadView('pdf.resume', [
            'resume' => $resume
        ]);

        return $pdf->download("resume_{$analyse->id}.pdf");


        $filePath = "resumes/{$analyse->id}.pdf";

        // if (!Storage::exists($filePath)) {
        //     Storage::put($filePath, $pdf->output());
        // }

        // return Storage::download($filePath);
    }

    public function downloadCoverLetter(int $id, Request $request){
        $analyse = $this->analyseRepository->find($id);
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }


        $pdf = Pdf::loadView('pdf.cover_letter', [
            'content' => $analyse->cover_letter
        ]);

        return $pdf->download('cover_letter.pdf');
    }

}
