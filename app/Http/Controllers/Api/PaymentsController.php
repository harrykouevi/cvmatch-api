<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Repositories\Interfaces\CreditPlanRepository;
use App\Repositories\Interfaces\CreditRepository;
use App\Repositories\Interfaces\CreditTransactionRepository;
use App\Repositories\Interfaces\PaymentRepository;
use Exception;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
     /** @var PaymentRepository */
    private PaymentRepository $paymentRepository;

     /** @var CreditPlanRepository */
    private CreditPlanRepository $creditPlanRepository;

     /** @var CreditRepository */
    private CreditRepository $creditRepository;

     /** @var CreditTransactionRepository */
    private CreditTransactionRepository $creditTransactionRepository;


    public function __construct(PaymentRepository $paymentRepo,
                    CreditPlanRepository $creditPlanRepository,
                    CreditTransactionRepository $creditTransactionRepository,
                    CreditRepository $creditRepository,
    )
    {
        $this->paymentRepository = $paymentRepo;
        $this->creditPlanRepository = $creditPlanRepository;
        $this->creditTransactionRepository = $creditTransactionRepository;
        $this->creditRepository = $creditRepository;
        parent::__construct();
    }


    public function handleStripeWebhook(Request $request)
    {
        $sessionId = $request->data['object']['id'];

        //$payment = Payment::where('stripe_session_id', $sessionId)->first();
        $payment = $this->paymentRepository->findWhere(['stripe_session_id', $sessionId]);
        $payment = $this->paymentRepository->findByField('stripe_session_id', $sessionId);


        if (!$payment) return;

        if ($payment->status === 'paid') return; // éviter double crédit

        $payment->update(['status' => 'paid']);
        $this->paymentRepository->update(['status' => 'paid'],$payment->id);


        $plan = $this->creditPlanRepository->findByField('name', $payment->plan);

        // snapshot pricing
        $snapshot = [
            'plan' => $plan->name,
            'credits' => $plan->credits,
            'price' => $plan->price,
        ];

        $this->addCredits(
            $payment->user_email,
            $plan->credits,
            $payment->id,
            $snapshot
        );
    }

    public function handleGumroadWebhook(Request $request)
    {
        $data = $request->all();
         // 1. éviter doublon
        if (Purchase::where('provider', $data['provider'])
                ->where('provider_sale_id', $data['sale_id'])->exists()) {
            return response()->json(['ok']);
        }

        $sessionId = $request->data['object']['id'];

        //$payment = Payment::where('stripe_session_id', $sessionId)->first();
        $payment = $this->paymentRepository->findWhere(['stripe_session_id', $sessionId]);
        $payment = $this->paymentRepository->findByField('stripe_session_id', $sessionId);


        // 3. sauvegarder achat
        Purchase::create([
            'gumroad_sale_id' => $data['sale_id'],
            'email' => $data['email'],
            'user_id' => $user?->id,
            'product_id' => $data['product_id'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'status' => 'paid'
        ]);

        if (!$payment) return;

        if ($payment->status === 'paid') return; // éviter double crédit

        $payment->update(['status' => 'paid']);
        $this->paymentRepository->update(['status' => 'paid'],$payment->id);


        $plan = $this->creditPlanRepository->findByField('name', $payment->plan);

        // snapshot pricing
        $snapshot = [
            'plan' => $plan->name,
            'credits' => $plan->credits,
            'price' => $plan->price,
        ];

        $this->addCredits(
            $payment->user_email,
            $plan->credits,
            $payment->id,
            $snapshot
        );
    }

    private function addCredits($email, $credits, $paymentId, $snapshot)
    {
        $current = $this->creditRepository->findByField('user_email', $email)->first();

        if (!$current) {
            $current = $this->creditRepository->create([
                'user_email' => $email,
                'remaining_credits' => 0,
            ]);
        }

        $newBalance = $current->remaining_credits + $credits;

        $current = $this->creditRepository->update([
            'remaining_credits' => $newBalance
        ],$current->id);

        $this->creditTransactionRepository->create([
            'user_email' => $email,
            'payment_id' => $paymentId,
            'type' => 'purchase',
            'credits' => $credits,
            'balance_after' => $newBalance,
            'pricing_snapshot_json' => json_encode($snapshot),
            'description' => 'Achat crédits'
        ]);
    }


}
