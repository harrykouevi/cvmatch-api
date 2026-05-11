<?php

namespace App\Listeners;

use App\Events\AiCleanTextEvent;
use App\Events\AiPerfomEvent;
use App\Repositories\Interfaces\ResumeRepository;
use App\Services\OpenAIResumeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AiCleanTextEventListener
{

    /**
     * Create the event listener.
     */
    public function __construct(
        private ResumeRepository $resumeRepository ,
        private OpenAIResumeService $service
    )
    {}

    /**
     * Handle the event.
     */
    public function handle(AiCleanTextEvent $event): void
    {
        try{
            $response = $this->service->cleanText($event->text) ;
            Log::info('openAI response#' , [
                'response' => $response,
            ]);

            $aiData = $response['data'] ?? null;

            if (!$aiData) {
                Log::error('Invalid AI response');
                return;
            }

            $data = [
               'extracted_text' => $aiData['text_clean']
            ] ;

            $this->resumeRepository->update($data,$event->resume->id);
        } catch (\Exception $e) {
            // Gestion de l'exception
            Log::error('AiCleanTextEvent resume#' . $event->resume->id, [
                'exception' => $e,
            ]);
        }
    }
}
