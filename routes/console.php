<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::call(function () {
    foreach (['gumroad'] as $provider) {
        dispatch(new \App\Jobs\SyncProductProviderJob($provider));
    }
})->everyFiveSeconds();
// ->everyFiveMinutes();
