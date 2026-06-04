<?php

namespace App\Jobs;

use App\Models\Analyse;
use App\Models\Resume;
use App\Models\User;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Services\OpenAIResumeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AiPerformJob implements ShouldQueue
{
    // use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 5;
    public $timeout = 120;
    public $backoff = [10, 30, 60];

    /**
     * Create a new job instance.
     */
    public function __construct(public Analyse $analyse )
    {
        $this->onQueue('ai');
    }

    /**
     * Execute the job.
     */
    public function handle(AnalyseRepository $analyseRepository , OpenAIResumeService $service): void
    {
        Log::info('Starting AI job ');

        $analyse = Analyse::findOrFail($this->analyse->id);
        $analyseId = $analyse->id;
        Log::info('Starting AI job ', ['analyse_id' => $analyseId]);


        $lockKey = "ai:analyse:{$analyse->id}";
        $lock = Cache::lock($lockKey, 600);
        if (! $lock->get()) {
            Log::info('AI job already running', ['analyse_id' => $analyseId]);
            return;
        }

        try{

            if ($analyse->status === 'completed') {
                return;
            }
            $wasLocked = $analyse->where('id', $analyse->id)
                ->where('status', 'pending')
                ->update(['status' => 'processing']) ;
            if (! $wasLocked) {
                Log::info('AI already processing', [
                    'analyse_id' => $analyseId,
                ]);
                return;
            }


            $resumeText = $analyse->resume?->extracted_text ;
            // $resumeText = $analyse->resume?->extracted_text  ?? null;
            // =====================================================
            // RETRY SAFE WAIT (DEPENDENCY: extract text job)
            // =====================================================
            //  if (blank($resumeText)) {
            //     Log::info('Waiting for extracted_text generation', [ 'analyse_id' => $analyse?->id,'attempt' => $this->attempts(), ]);
            //     if ($this->attempts() >= $this->tries) {
            //         Log::error('Resume text still empty after max retries', [ 'analyse_id' => $analyseId, ]);
            //         $analyse->update([ 'status' => 'failed', ]);
            //         return;
            //     }

            //     $analyse->update([ 'status' => 'pending', ]);
            //     $this->release(15);
            //     return;
            // }

            if (blank($analyse->job_description)) {
                Log::error('Job description empty', [ 'analyse_id' => $analyse->id,]);
                $analyse->update(['status' => 'failed']);
                return;
            }

            $response = $service->analyze($resumeText, $analyse->job_description);
            Log::info('openAI response AiPerfomEvent#' , [ 'response' => $response, ]);

            if (! ($response['success'] ?? false)) {
                // =====================================================
                // RETRY ONLY FOR RETRYABLE AI ERRORS
                // =====================================================

                $analyse->update([ 'ai_attempts' => ($analyse->ai_attempts ?? 0) + 1, ]);
                $aiAttempts = $analyse->ai_attempts;

                if (($response['retryable'] ?? false) && $aiAttempts < 5) {
                    Log::warning('Retrying OpenAI request', [ 'analyse_id' => $analyse->id, 'ai_attempt' => $aiAttempts]);
                    $analyse->update(['status' => 'pending' ]);
                    $this->release(20);
                    return;
                }
                Log::error('AI analysis failed permanently', [ 'analyse_id' => $analyseId, 'response' => $response,]);
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

            Analyse::where('id', $analyse->id)
                ->where('status', 'processing')
                ->update($data) ;

            Resume::where('id', $analyse->resume->id)->update(['extracted_text'=>  $aiData["original_resume"]["text_clean"] ]);
            User::where('id', $analyse->user_id)->update(['current_analyse_done'=>  $analyse->id ]);
            // $analyseRepository->update($data,$analyseId);
            Log::info('AI analysis completed successfully', [ 'analyse_id' => $analyseId,]);
        } catch (\Throwable $e) {

            Log::error('AiPerfomEventListener failed', [
                'message' => $e->getMessage(),
                'analyse_id' => $event->analyse->id ?? null,
            ]);

            // $analyse->update(['status' => 'failed']);
            Analyse::where('id', $this->analyse->id)
                ->where('status', 'processing')
                ->update(['status' => 'failed']);

            // IMPORTANT : relance exception => active retry Laravel
            throw $e;
        } finally {
            optional($lock)->release();
        }
    }

}
