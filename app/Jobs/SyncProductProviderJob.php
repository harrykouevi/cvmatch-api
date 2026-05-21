<?php

namespace App\Jobs;

use App\Services\Providers\CreditPlanProviderFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SyncProductProviderJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct( public string $provider)
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(CreditPlanProviderFactory $factory): void
    {
        Log::info('JOB STARTED', [
            'provider' => $this->provider,
        ]);


        $lock = Cache::lock("sync_{$this->provider}", 300);

        if (!$lock->block(5)) {
            return;
        }

        try {
            $providerService = $factory->make($this->provider);
            $providerService->sync();
        } catch (\Throwable $e) {

            Log::error('SYNC FAILED', [
                'provider' => $this->provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e; // IMPORTANT

        } finally {
            // cache()->forget("sync_{$this->provider}");
            optional($lock)->release();
        }
    }
}
