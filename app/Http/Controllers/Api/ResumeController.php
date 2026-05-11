<?php

namespace App\Http\Controllers\Api;

use App\Events\AiCleanTextEvent;
use App\Http\Controllers\Api\Controller;
use App\Models\Resume;
use App\Repositories\Interfaces\ResumeRepository;
use App\Repositories\Interfaces\UploadRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResumeController extends Controller
{
      /** @var ResumeRepository */
    private ResumeRepository $resumeRepository;


    /** @var UploadRepository */
    private UploadRepository $uploadRepository;

    public function __construct(ResumeRepository $resumeRepo,
                                UploadRepository $uploadRepository
    )
    {
        $this->uploadRepository = $uploadRepository;
        $this->resumeRepository = $resumeRepo;
        parent::__construct();
    }

    public function store(Request $request): JsonResponse
    {
        try {

            $this->validate($request, [
                'name' => Resume::$rules['name'],
                // 'media' => ['required', 'array'],
                // 'media.*' => ['file', 'max:10240', 'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            ]);

            $input = $request->all();
            $input['uuid'] = (isset($input['uuid']) && Str::isUuid($input['uuid'])) ? $input['uuid'] : (string) Str::uuid();


            $resume = $this->resumeRepository->create($input);

            if (isset($input['media']) && is_array($input['media'])) {

                if (!$request->hasFile('media')) {
                    throw ValidationException::withMessages([
                        'media' => 'Le fichier resume est obligatoire.',
                    ]);
                }

                $files = $request->file('media');
                if (empty($files)) {
                    throw ValidationException::withMessages([
                        'media' => 'Le fichier resume est obligatoire.',
                    ]);
                }

                foreach($files as $file){

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

                    $input['original_file_name'] =   $file->getClientOriginalName() ;
                    $input['file_type'] =   $file->getClientMimeType() ;

                    $resume = $this->resumeRepository->update($input,$resume->id);
                    event(new AiCleanTextEvent($resume ,$this->extractText($file)));

                    $in = [
                        'uuid' =>  (string) Str::uuid() ,
                        'field' => 'media' ,
                    ] ;
                    $this->uploadRepository->createWithMedia($file,$in,$resume);
                }
            }else{
                throw ValidationException::withMessages([
                    'media' => 'no mediaa ooooo',
                ]);
            }


            $resume->load('media');

        } catch (ValidationException $e) {
            Log::error("Error validation resume: " . $e->getMessage());
            return $this->sendError(array_values($e->errors()), 422);
        } catch (Exception $e) {
            Log::error("Error storing resume: " . $e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }

        if (isset($input['media']) && is_array($input['media'])) {
            $message = "Votre resume a bien été enregistré, mais il est en cours de traitement car il contient un média.";
        } else {
            $message = "Votre resume a bien été enregistré.";
        }

        return $this->sendResponse($resume, __('lang.saved_successfully', ['operator' => __('lang.resume')]));
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
