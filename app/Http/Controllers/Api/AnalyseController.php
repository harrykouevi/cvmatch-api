<?php

namespace App\Http\Controllers\Api;

use App\Criteria\AnalyseOfUserCriteria;
use App\Criteria\LimitOffsetCriteria;
use App\Events\AiPerfomEvent;
use App\Http\Controllers\Api\Controller;
use App\Models\Analyse;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Repositories\Interfaces\CreditRepository;
use App\Repositories\Interfaces\CreditTransactionRepository;
use App\Repositories\Interfaces\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;

class AnalyseController extends Controller
{

      /** @var AnalyseRepository */
    private AnalyseRepository $analyseRepository;

     /** @var CreditRepository */
    private CreditRepository $creditRepository;

      /** @var CreditTransactionRepository */
    private CreditTransactionRepository $creditTransactionRepository;

    /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(AnalyseRepository $analyseRepo ,
        CreditRepository $creditRepository,
        CreditTransactionRepository $creditTransactionRepository,
        UserRepository $userRepo

    )
    {
        $this->creditRepository = $creditRepository;
        $this->analyseRepository = $analyseRepo;
        $this->creditTransactionRepository = $creditTransactionRepository;
        $this->userRepository = $userRepo;

        parent::__construct();
    }

    public function store(Request $request): JsonResponse
    {

        try {
            $user = Auth::user() ?? $request->attributes->get('current_user');
            if (!$user) {
                throw new Exception("User not authenticated");
            }

            $this->validate($request, Analyse::$rules   );

            $input = $request->all();
            $input['status'] = 'pending';
            $input['user_id'] = $user->id;
            $input['is_full_unlocked'] = false;

            $analyse = $this->analyseRepository->create($input);
            Log::info("about to perform ai :");

            //event senttoperforme AI prompt
            event(new AiPerfomEvent($analyse));

        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()), 422);
        } catch (Exception $e) {
            Log::error("Error storing analyse: " . $e->getMessage());

            return $this->sendError($e->getMessage(), 500);
        }
        $response = $this->sendResponse($this->partialResponse($analyse), __('lang.saved_successfully', ['operator' => __('lang.resume')]));
        return $response;
    }


    public function unlockFullResult(int $id, Request $request): JsonResponse
    {
        try {

            $user = Auth::user() ?? $request->attributes->get('current_user');

            if (!$user) {
                return $this->sendError('User not authenticated', 401);
            }

            $analyse = DB::transaction(function () use ($id, $user) {

                $this->analyseRepository->pushCriteria( new AnalyseOfUserCriteria($user->id));

                $analyse = $this->analyseRepository ->findWhere(['id' => $id ]) ->first();

                if (!$analyse) {
                    throw new Exception('Analyse not found');
                }

                // déjà débloqué
                if ($analyse->is_full_unlocked) {
                    return $analyse;
                }

                $cost = 1;
                $credit = $this->creditRepository ->findByField('user_id', $user->id)->first();

                if (!$credit) {
                    throw new Exception('Not enough credits');
                }

                if ($credit->balance < $cost) {
                    throw new Exception('Not enough credits');
                }

                // consommation crédit
                $this->consumeCredit($user->id, $cost);

                $analyse->update([ 'is_full_unlocked' => true ]);

                return $analyse->fresh();
            });

            return $this->sendResponse(
                $this->fullResponse($analyse),
                'Full result retrieved successfully'
            );

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }
    }


    public function show(int $id, Request $request): JsonResponse
    {
        $user = Auth::user() ?? $request->attributes->get('current_user');
        if (!$user) {
            throw new Exception("User not authenticated");
        }

        try {
            $this->analyseRepository->pushCriteria(new AnalyseOfUserCriteria($user->id));
            $this->analyseRepository->pushCriteria(new RequestCriteria($request));
            $this->analyseRepository->pushCriteria(new LimitOffsetCriteria($request));
            $analyse = $this->analyseRepository->findWhere([
                'id' => $id
            ])
            ->first();
            if (empty($analyse)) {
                return $this->sendError('Analyse not found');
            }

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
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





    private function partialResponse(Analyse $analysis)
    {
        return[
            'id' => $analysis->id,
            'resume_id' => $analysis->resume_id,
            'user_id' => $analysis->user_id,
            'status' => $analysis->status,
            'score' => $analysis->score,
            'match_level' => $analysis->match_level,
            'critical_issues' => $analysis->critical_problems_json,
            'score_breakdown' => $analysis->score_breakdown_json,
            'missing_keywords' => $analysis->missing_keywords_json,
            'optimized_resume_analysis' => $analysis->optimized_resume_analysis_json,
            'optimized_resume_text' => substr( $analysis->optimized_resume_text, 0, 200),
            'posted_resume' => $analysis->resume->extracted_text,
            'locked' => true
        ];
    }

    private function fullResponse(Analyse $analysis)
    {
        return [
            'id' => $analysis->id,
            'resume_id' => $analysis->resume_id,
            'user_id' => $analysis->user_id,
            'status' => $analysis->status,
            'score' => $analysis->score,
            'match_level' => $analysis->match_level,
            'critical_issues' => $analysis->critical_problems_json,
            'score_breakdown' => $analysis->score_breakdown_json,
            'missing_keywords' => $analysis->missing_keywords_json,
            'optimized_resume_analysis' => $analysis->optimized_resume_analysis_json,
            'optimized_resume' => $analysis->optimized_resume,
            'optimized_resume_text' => $analysis->optimized_resume_text,
            'posted_resume' => $analysis->resume->extracted_text,
            'cover_letter' => $analysis->cover_letter,
            'preview' => $analysis->optimized_resume_text,
            'locked' => false
        ];
    }

    private function consumeCredit(int $userId, int $credits)
    {
        return DB::transaction(function () use  ($userId, $credits) {
            $wallet = $this->creditRepository->findByField('user_id', $userId)->first();
            $wallet->lockForUpdate();
            if (!$wallet) {
                throw new Exception('Credit wallet not found');
            }
            if ($wallet->balance < $credits) {
                throw new Exception('Insufficient credits');
            }

            $newBalance = $wallet->balance - $credits;

            $this->creditRepository->update([
                'balance' => $newBalance,
                'used' => $wallet->used + $credits,
            ],$wallet->id);

            $this->creditTransactionRepository->create([
                'user_id' => $userId,
                'type' => 'usage',
                'credits' => -$credits,
                'balance_after' => $newBalance,
                'description' => 'Full analysis unlock',
            ]);

            return $wallet->fresh();
        });
    }


    public function downloadResume(int $id, Request $request){


        $this->analyseRepository->pushCriteria(new AnalyseOfUserCriteria($request->user()->id));
        $analyse = $this->analyseRepository->find($id);
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }

        // $this->authorize('view', $analyse);

        // if (!$analyse->is_full_unlocked) {
        //     return $this->sendError('Access denied. Unlock full result first.', 403);
        // }
        $using_array = false ;
        if($using_array == true ){
            $resume = json_decode($analyse->optimized_resume, true);
            if (!$resume) {
                return $this->sendError('Resume data invalid', 500);
            }

            $pdf = Pdf::loadView('pdf.resume', [
                'resume' => $resume
            ]);
        }else{
            $resume = $analyse->optimized_resume_text ;
            $pdf = Pdf::loadHTML("
                <html> <head> <meta charset='UTF-8'> <style> body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; color: #222; padding: 30px; } </style></head>
                    <body> <pre>{$resume}</pre> </body>
                </html>
            ");
        }
        return $pdf->download("resume_{$analyse->id}.pdf");
    }

    public function downloadCoverLetter(int $id, Request $request){

        $this->analyseRepository->pushCriteria(new AnalyseOfUserCriteria($request->user()->id));
        $analyse = $this->analyseRepository->find($id);
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }

        $using_array = false ;
        if($using_array == true ){

            $pdf = Pdf::loadView('pdf.cover_letter', [
                'content' => $analyse->cover_letter
            ]);
        }else{
            $resume = $analyse->cover_letter ;
            $pdf = Pdf::loadHTML("
                <html> <head> <meta charset='UTF-8'> <style> body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; color: #222; padding: 30px; } </style></head>
                    <body> <pre>{$resume}</pre> </body>
                </html>
            ");
        }

        return $pdf->download('cover_letter.pdf');
    }

}
