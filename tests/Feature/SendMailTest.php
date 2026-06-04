<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;


class SendMailTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        try{
            Mail::to("harry.kouevi@gmail.com")->queue(
                new PaymentSuccessMail([
                    'first_name' => "Kouevi",
                    'plan_name' => 'Job Search Pack',
                    'amount' => '$' . number_format(1000, 2),
                    'credits_added' => 5,
                    'current_balance' => 20,
                    'transaction_id' => "7GTJZKK2KBX80CV6JV56XXVVX",
                    'dashboard_url' => config('app.frontend_url') . '/?from=email_checkout&to=dashboard',
                    'app_url' => config('app.frontend_url'). '/?from=email_checkout&to=app',
                    'support_email' => 'assistance@cvmatchai.us',
                ])
            );

        } catch (\Exception $e) {
            Log::error('FAIL:'. $e->getMessage() , [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
