<?php

namespace App\Console\Commands;

use App\Models\Analyse;
use App\Models\Resume;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Retention cleanup: purge stale sensitive resume/analysis data older than the
 * configured retention window (services.cvmatch.data_retention_days, default 90).
 *
 * Internal command (no public endpoint). Logs counts only, never CV/JD/AI content.
 * Does NOT touch payments, credit plans, credits, pricing, checkout or webhooks.
 */
class CleanupOldData extends Command
{
    protected $signature = 'cvmatch:cleanup-old-data {--days= : Override retention days (defaults to config)}';

    protected $description = 'Purge sensitive resume & analysis data older than the retention period.';

    public function handle(): int
    {
        $days = (int) ($this->option('days') ?: config('services.cvmatch.data_retention_days', 90));
        if ($days < 1) {
            $this->error('Retention days must be >= 1.');
            return self::FAILURE;
        }

        $cutoff = now()->subDays($days);

        $analysesCount = 0;
        $resumesCount = 0;

        DB::transaction(function () use ($cutoff, &$analysesCount, &$resumesCount) {
            Analyse::where('created_at', '<', $cutoff)
                ->get()
                ->each(function (Analyse $analyse) use (&$analysesCount) {
                    $analyse->forceFill([
                        'optimized_resume'               => null,
                        'optimized_resume_text'          => null,
                        'optimized_resume_analysis_json' => null,
                        'cover_letter'                   => null,
                    ])->save();
                    $analyse->delete();
                    $analysesCount++;
                });

            Resume::where('created_at', '<', $cutoff)
                ->get()
                ->each(function (Resume $resume) use (&$resumesCount) {
                    $resume->forceFill(['extracted_text' => null])->save();
                    if (method_exists($resume, 'clearMediaCollection')) {
                        try {
                            $resume->clearMediaCollection();
                        } catch (\Throwable $e) {
                            // best-effort; never log file content
                        }
                    }
                    $resume->delete();
                    $resumesCount++;
                });
        });

        Log::info('cvmatch:cleanup-old-data completed', [
            'retention_days'  => $days,
            'analyses_purged' => $analysesCount,
            'resumes_purged'  => $resumesCount,
            'status'          => 'completed',
        ]);

        $this->info("Purged {$analysesCount} analyses and {$resumesCount} resumes older than {$days} days.");

        return self::SUCCESS;
    }
}
