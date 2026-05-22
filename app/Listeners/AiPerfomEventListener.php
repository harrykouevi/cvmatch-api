<?php

namespace App\Listeners;

use App\Events\AiPerfomEvent;
use App\Jobs\AiPerformJob;
use Illuminate\Support\Facades\Log;

class AiPerfomEventListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(AiPerfomEvent $event): void
    {
        Log::info('abraaa' );
        Log::info('LISTENER HIT', [
            'analyse_id' => $event->analyse->id,
            'time' => microtime(true),
        ]);

        AiPerformJob::dispatch($event->analyse);
    }
}
