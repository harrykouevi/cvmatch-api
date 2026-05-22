<?php

namespace App\Listeners;

use App\Events\AiPerfomEvent;
use App\Jobs\AiPerformJob;
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
        AiPerformJob::dispatch($event->analyse);
    }
}
