<?php

namespace App\Http\Controllers\Api;

use App\Events\AiCleanTextEvent;
use App\Http\Controllers\Api\Controller;
use App\Models\Resume;
use App\Repositories\Interfaces\ResumeRepository;
use App\Repositories\Interfaces\UploadRepository;
use App\Repositories\Interfaces\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResumeController extends Controller
{
      /** @var ResumeRepository */
    private ResumeRepository $resumeRepository;


    /** @var UploadRepository */
    private UploadRepository $uploadRepository;

     /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(ResumeRepository $resumeRepo,
                                UploadRepository $uploadRepository,
                UserRepository $userRepo

    )
    {
        $this->uploadRepository = $uploadRepository;
        $this->resumeRepository = $resumeRepo;
        $this->userRepository = $userRepo;

        parent::__construct();
    }

    private function storeResumeWithMedia(Request $request, $user)
    {
        $this->validate($request, [
            'name' => Resume::$rules['name'],
        ]);

        $input = $request->all();

        $input['uuid'] = (isset($input['uuid']) && Str::isUuid($input['uuid']))
            ? $input['uuid']
            : (string) Str::uuid();

        $input['user_id'] = $user->id;

        $resume = $this->resumeRepository->create($input);

        $files = $request->file('media');

        if (!$files || empty($files)) {
            throw ValidationException::withMessages([
                'media' => 'Le fichier resume est obligatoire.',
            ]);
        }

        foreach ($files as $file) {

            if (!$file) {
                throw ValidationException::withMessages([
                    'media' => 'Fichier invalide.',
                ]);
            }

            $mime = $file->getMimeType();

            if (!in_array($mime, [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword',
            ])) {
                throw ValidationException::withMessages([
                    'media' => 'Format de fichier non supporté.',
                ]);
            }

            $input['original_file_name'] = $file->getClientOriginalName();
            $input['file_type'] = $file->getClientMimeType();
            $input[ 'extracted_text'] = $this->extractText($file) ;


            $resume = $this->resumeRepository->update($input, $resume->id);


            //a cet etape pas de cleaning
            //event(new AiCleanTextEvent( $resume, $this->extractText($file)));

            $this->uploadRepository->createWithMedia(
                $file,
                [
                    'uuid' => (string) Str::uuid(),
                    'field' => 'media',
                ],
                $resume
            );
        }

        $this->userRepository->update(['current_analyse_done'=>  null ], $user->id);

        $resume->load('media');
        return $resume;
    }

    public function visitorStore(Request $request): JsonResponse
    {
        try {

            $guestToken = $request->header('X-Guest-Token');
            $user = null;
            if ($guestToken) {
                $user = $this->userRepository->findWhere([ 'guest_token' => $guestToken,'is_guest'=> true])->first();
            }

            if(!$user){
                $guestToken = (string) \Illuminate\Support\Str::uuid();
                $user = $this->userRepository->create([
                    "name"=> "Guest",
                    'is_guest' => 1 , // ou false
                    'guest_token' => $guestToken,
                ]);
                $input['user_id'] = $user->id ;
            }
            $resume = $this->storeResumeWithMedia($request, $user);

            $response = $this->sendResponse($resume, __('lang.saved_successfully', ['operator' => __('lang.resume')]));
            return $response->header('X-Guest-Token', $user->guest_token);

        } catch (Exception $e) {
            Log::error("Error storing resume: " . $e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }

    }

    public function store(Request $request): JsonResponse
    {
        try {
            $user = Auth::user() ?? $request->attributes->get('current_user');
            if (!$user) {
                throw new Exception("User not authenticated");
            }

            $resume = $this->storeResumeWithMedia($request, $user);
            $response = $this->sendResponse($resume, __('lang.saved_successfully', ['operator' => __('lang.resume')]));

            if(Auth::user()){
                return $response;
            }
            return $response->header('X-Guest-Token', $request->header('X-Guest-Token'));

        } catch (Exception $e) {
            Log::error("Error storing resume: " . $e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }

    }



    private function extractText($file) :string
    {
        $text = null;
        switch ($file->getMimeType()) {

            case 'application/pdf':
                $parser = new \Smalot\PdfParser\Parser();
                $text = $parser->parseFile($file->getPathname())->getText();
                break;

            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getPathname());

                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . " ";
                        }
                    }
                }
                break;

            default:
                $text = null;
        }

        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
        // nettoyer caractères cassés
        // $text = preg_replace('/[^\x{0000}-\x{FFFF}]/u', '', $text);
        return trim($text);
    }

}
