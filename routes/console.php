<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::call(function () {
    // foreach (['gumroad','paddle'] as $provider) {
    //     dispatch(new \App\Jobs\SyncProductProviderJob($provider));
    // }
})
// ->everyFiveSeconds();
->everyMinute();

// Privacy retention: purge stale resume/analysis sensitive data daily.
Schedule::command('cvmatch:cleanup-old-data')->daily();
