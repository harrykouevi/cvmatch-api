<?php

namespace App\Console\Commands;

use App\Models\Analyse;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Privacy deletion-by-request: purge all sensitive CV/analysis data for a user.
 *
 * Internal/admin command only (no public endpoint). Logs counts + user_id only,
 * never CV text, job descriptions, OpenAI output, tokens or payment data.
 * Does NOT touch payments, credit plans, credits balances, pricing or webhooks.
 */
class PurgeUserData extends Command
{
    protected $signature = 'cvmatch:purge-user-data {email : Email of the user whose data must be purged}';

    protected $description = 'Delete/anonymize all sensitive resume & analysis data for a user (privacy request).';

    public function handle(): int
    {
        $email = (string) $this->argument('email');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->warn('No user found for that email. Nothing to purge.');
            return self::SUCCESS;
        }

        $analysesCount = 0;
        $resumesCount = 0;

        DB::transaction(function () use ($user, &$analysesCount, &$resumesCount) {
            $analyses = Analyse::where('user_id', $user->id)->get();
            foreach ($analyses as $analyse) {
                // Null sensitive generated content before removing the row.
                $analyse->forceFill([
                    'optimized_resume'               => null,
                    'optimized_resume_text'          => null,
                    'optimized_resume_analysis_json' => null,
                    'cover_letter'                   => null,
                ])->save();
                $analyse->delete();
                $analysesCount++;
            }

            $resumes = Resume::where('user_id', $user->id)->get();
            foreach ($resumes as $resume) {
                $resume->forceFill(['extracted_text' => null])->save();
                // Remove any stored media files if the model uses media-library.
                if (method_exists($resume, 'clearMediaCollection')) {
                    try {
                        $resume->clearMediaCollection();
                    } catch (\Throwable $e) {
                        // Media clearing is best-effort; do not log file content.
                    }
                }
                $resume->delete();
                $resumesCount++;
            }
        });

        Log::info('cvmatch:purge-user-data completed', [
            'user_id'        => $user->id,
            'analyses_purged' => $analysesCount,
            'resumes_purged'  => $resumesCount,
            'status'          => 'completed',
        ]);

        $this->info("Purged {$analysesCount} analyses and {$resumesCount} resumes for user #{$user->id}.");

        return self::SUCCESS;
    }
}
