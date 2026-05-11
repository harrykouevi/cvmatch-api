<?php

use App\Http\Controllers\Api\AnalyseController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\MobileWaitlistController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ResumeController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::prefix('v1')->group(function () {

    // POST /api/resumes/upload ✔️
    Route::post('/resumes/upload', [ResumeController::class, 'store'])->name('resumes.upload');

    // POST /api/analyses/create✔️
    Route::post('/analyses', [AnalyseController::class, 'store'])->name('analyses.store');

    // GET /api/analyses/{id}/free-result✔️
    Route::get('/analyses/{id}', [AnalyseController::class, 'show'])->name('analyses.show');

    // GET /api/credit-plans✔️
    Route::get('/credit-plans', [ProductController::class, 'index'])->name('credit-plans.index');

    // POST /api/events/track
    Route::post('events/track', [EventController::class, 'store'])->name('events.store');

    // POST /api/mobile-waitlist
    Route::post('/mobile-waitlist/', [MobileWaitlistController::class, 'store'])->name('mobile-waitlist.store');

    // POST /api/reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    //✔️
    Route::get('/analyses/{id}/download/resume', [AnalyseController::class, 'downloadResume'])->name('analyses.download.resume');
    //✔️
    Route::get('/analyses/{id}/download/cover-letter', [AnalyseController::class, 'downloadCoverLetter']);

    Route::post('/payments/webhooks/gumroad', [PaymentsController::class, 'handleGumroadWebhook'])->name('payments.webhooks.gumroad');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'show']);



    });

    Route::middleware(['auth:api','set.tenant'])->group(function () {
        // GET /api/analyses/{id}/full-result✔️
        //Route::get('/analyses/{id}/full-result', [AnalyseController::class, 'showFullResult'])->name('analyses.getfullresult');



        // POST /api/payments/webhook
        Route::post('/payments/webhook', [PaymentsController::class, 'webhook'])->name('payments.webhook');



    });
});


Route::prefix('v1')->group(function () {
    //
});




