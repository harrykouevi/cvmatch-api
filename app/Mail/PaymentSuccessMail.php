<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentSuccessMail extends Mailable implements ShouldQueue
{


    use Queueable, SerializesModels;

    public array $purchase;

    public function __construct(array $purchase)
    {
        $this->purchase = $purchase;

        $this->onQueue('ai');
    }

    public function build()
    {
        return $this
            ->subject('Payment Confirmed - Your CVMatch AI Credits Are Ready')
            ->view('emails.payment-success')
            ->text('emails.payment-success-text')
            ->with([
                'firstName' => $this->purchase['first_name'] ?? 'there',
                'planName' => $this->purchase['plan_name'] ?? 'CVMatch AI Credit Pack',
                'amount' => $this->purchase['amount'] ?? '$0.00',
                'creditsAdded' => $this->purchase['credits_added'] ?? 0,
                'currentBalance' => $this->purchase['current_balance'] ?? 0,
                'transactionId' => $this->purchase['transaction_id'] ?? 'N/A',
                'dashboardUrl' => $this->purchase['dashboard_url'] ?? config('app.url') . '/?where=dashboard',
                'appUrl' => $this->purchase['app_url'] ?? config('app.url') ,
                'supportEmail' => $this->purchase['support_email'] ?? 'assistance@cvmatchai.us',
            ]);
    }
}
