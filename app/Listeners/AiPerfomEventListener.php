<?php

namespace App\Listeners;

use App\Events\AiPerfomEvent;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Services\OpenAIResumeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use Throwable;

class AiPerfomEventListener implements ShouldQueue
{
    public $tries = 5;

    public $backoff = [10, 30, 60];

    /**
     * Create the event listener.
     */
    public function __construct(
        private AnalyseRepository $analyseRepository ,
        private OpenAIResumeService $service
    )
    {}

    /**
     * Handle the event.
     */
    public function handle(AiPerfomEvent $event): void
    {
        try{

            $resumeText = $event->analyse->resume->extracted_text ;
            if (is_null($resumeText) || trim($resumeText) === '') {
                throw new \Exception('Resume text is empty');
            }

            $jobDescription= $event->analyse->job_description ;
            $response = $this->service->analyze($resumeText, $jobDescription) ;
            Log::info('openAI response#' , [
                'response' => $response,
            ]);

            $aiData = $response['data'] ?? null;

            if (!$aiData) {
                Log::error('Invalid AI response');
                return;
            }

            $data = [
                // "analysis_id"=> $event->analyse->id,
                'status' =>'completed',
                "score"=>  $aiData['ats_score'] ?? 0,
                "score_breakdown_json" => [
                        "match_level" => $aiData['match_level'] ?? null,
                        "job_fit_summary" => $aiData['job_fit_summary'] ?? null,
                    ],

                "critical_problems_json" => array_merge(
                        $aiData['weak_sections'] ?? [],
                        $aiData['warnings'] ?? []
                    ),
                "missing_keywords_json" => $aiData['missing_keywords'] ?? [],

                "ats_issues_json"=> $aiData['warnings'] ?? [],

                "optimized_resume"  => json_encode($aiData['optimized_resume'] ?? []),

                "cover_letter" => $aiData['cover_letter'] ?? null,


            ] ;

            $this->analyseRepository->update($data,$event->analyse->id);
        } catch (\Throwable $e) {

            Log::error('AiPerfomEventListener failed', [
                'message' => $e->getMessage(),
                'analyse_id' => $event->analyse->id ?? null,
            ]);

            // IMPORTANT : relance exception => active retry Laravel
            throw $e;
        }
    }
}
