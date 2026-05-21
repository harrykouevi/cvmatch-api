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
                log::error(['AiPerfomEvent resumetext empty']) ;
                throw new \Exception('Resume text is empty');
            }

            $jobDescription= $event->analyse->job_description ;
            $response = $this->service->analyze($resumeText, $jobDescription) ;
            Log::info('openAI response AiPerfomEvent#' , [
                'response' => $response,
            ]);

            $aiData = $response['data'] ?? null;

            if (!$aiData) {
                Log::error('AiPerfomEvent Invalid AI response');
                return;
            }

            $data = [
                // "analysis_id"=> $event->analyse->id,
                'status' =>'completed',
                "score"=>  $aiData['original_resume']['overall_ats_score'] ?? 0,
                "match_level"=>  $aiData['original_resume']['match_level'] ?? null,

                "job_fit_summary"=>  $aiData['original_resume']['job_fit_summary'] ?? null,
                "score_breakdown_json"  => $aiData['original_resume']['scoring_breakdown'] ?? [],
                "missing_keywords_json" => $aiData['original_resume']['missing_keywords'] ?? [],
                "missing_hard_skills_json"=> $aiData['original_resume']['missing_hard_skills'] ?? [],
                "weak_sections_json" => $aiData['original_resume']['weak_sections'] ?? [],
                "strong_points_json" => $aiData['original_resume']['strong_points'] ?? [],
                "detected_problems_json" => $aiData['original_resume']['detected_problems'] ?? [],
                "recruiter_risk_flags_json" => $aiData['original_resume']['recruiter_risk_flags'] ?? [],
                "recommendations_json" => $aiData['recommendations'] ?? [],
                "warnings_json" => $aiData['warnings'] ?? [],

                // "optimized_resume"  => json_encode($aiData['optimized_resume_array'] ?? []),
                "optimized_resume"  => $aiData['optimized_resume_array'] ?? [],
                "optimized_resume_text" => $aiData['optimized_resume'] ?? null,
                "cover_letter" => $aiData['cover_letter'] ?? null,
                "optimized_resume_analysis_json" => $aiData['optimized_resume_analysis'] ?? [],
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
