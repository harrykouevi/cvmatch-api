<?php

namespace App\Listeners;

use App\Events\AiPerfomEvent;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Services\OpenAIResumeService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\ConnectException;

use Throwable;

class AiPerfomEventListener implements ShouldQueue
{
    use InteractsWithQueue;

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
        $analyse = $event->analyse;
        $analyseId = $analyse->id;

        if ($analyse->status === 'processing') {
            Log::info('AI already processing (DB lock)', [
                'analyse_id' => $analyseId
            ]);
            return;
        }
        $analyse->update(['status' => 'processing']);

        $lock = Cache::lock("ai-perfom-event:{$analyseId}", 120);

        if (! $lock->get()) {
            Log::info('AI job already running', ['analyse_id' => $analyseId]);
            $analyse->update(['status' => 'pending']);
            return;
        }

        try{

            $resumeText = $analyse?->resume?->extracted_text;

            // =====================================================
            // RETRY SAFE WAIT (DEPENDENCY: extract text job)
            // =====================================================
            if (empty(trim($resumeText ?? ''))) {
                Log::info('Waiting for extracted_text generation', [ 'analyse_id' => $analyse?->id,'attempt' => $this->attempts(), ]);
                if ($this->attempts() < $this->tries) {
                    $this->release(15);
                    return;
                }
                Log::error('Resume text still empty after max retries', ['analyse_id' => $analyse?->id, ]);
                $analyse->update(['status' => 'failed']);
                return; // stop définitivement
            }

            $jobDescription= $analyse->job_description ?? null;

            if (empty($jobDescription)) {
                Log::error('Job description empty', [ 'analyse_id' => $analyse->id,]);
                $analyse->update(['status' => 'failed']);
                return;
            }

            $response = $this->service->analyze($resumeText, $jobDescription);
            Log::info('openAI response AiPerfomEvent#' , [ 'response' => $response, ]);

            if (! $response['success']) {
                // =====================================================
                // RETRY ONLY FOR RETRYABLE AI ERRORS
                // =====================================================
                $aiAttempts = ($analyse->ai_attempts ?? 0) + 1;
                if (($response['retryable'] ?? false) === true) {

                    $analyse->update([ 'ai_attempts' => $aiAttempts,]);
                    if ($aiAttempts < 5) {
                        Log::warning('Retrying OpenAI request', [ 'analyse_id' => $analyse->id, 'ai_attempt' => $aiAttempts]);
                        $analyse->update(['status' => 'pending' ]);
                        $this->release(20);
                        return;
                    }
                }

                $analyse->update(['status' => 'failed']);
                return;
            }


            $aiData = $response['data'] ?? null;

            if (!$aiData) {
                Log::error('AiPerfomEvent Invalid AI response');
                $analyse->update(['status' => 'failed']);
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

            $this->analyseRepository->update($data,$analyse->id);
        } catch (\Throwable $e) {

            Log::error('AiPerfomEventListener failed', [
                'message' => $e->getMessage(),
                'analyse_id' => $event->analyse->id ?? null,
            ]);

            $analyse->update(['status' => 'failed']);

            // IMPORTANT : relance exception => active retry Laravel
            throw $e;
        } finally {
            optional($lock)->release();
        }
    }
}
