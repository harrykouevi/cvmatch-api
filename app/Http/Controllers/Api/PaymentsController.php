<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\CreditPlan;
use App\Models\User;
use App\Repositories\Interfaces\CreditPlanRepository;
use App\Repositories\Interfaces\CreditRepository;
use App\Repositories\Interfaces\CreditTransactionRepository;
use App\Repositories\Interfaces\PaymentRepository;
use App\Repositories\Interfaces\PurchaseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class PaymentsController extends Controller
{
    /** @var PaymentRepository */
    private PaymentRepository $paymentRepository;

     /** @var PurchaseRepository */
    private PurchaseRepository $purchaseRepository;

     /** @var CreditPlanRepository */
    private CreditPlanRepository $creditPlanRepository;

     /** @var CreditRepository */
    private CreditRepository $creditRepository;

     /** @var CreditTransactionRepository */
    private CreditTransactionRepository $creditTransactionRepository;


    public function __construct(
        PaymentRepository $paymentRepo,
        PurchaseRepository $purchaseRepo,
        CreditPlanRepository $creditPlanRepository,
        CreditTransactionRepository $creditTransactionRepository,
        CreditRepository $creditRepository,
    )
    {
        $this->paymentRepository = $paymentRepo;
        $this->purchaseRepository = $purchaseRepo;
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


    public function redirectToGumroad(Request $request)
    {
        $data = $request->all();
        $paylink = $data['link'] ?? null;
        return redirect("{$paylink}?wanted=true ");
    }

    public function handleGumroadWebhook(Request $request)
    {
        $data = $request->all();
        $saleId = $data['sale_id'] ?? null;

        $user = User::where('email', $data['email'])->first();
        $token = $user->createToken('api-token')->plainTextToken;

        if (!$saleId) {
            return response()->json(['error' => 'Missing sale_id'], 400);
        }

        DB::transaction(function () use ($data) {


            $existingPayment = $this->paymentRepository->findByField( 'provider_payment_id', $data['sale_id'])->first() ;
            if ($existingPayment && $existingPayment->status === 'paid') {
                return;
            }

            $user = User::where('email', $data['email'])->first();

            $payment = $this->paymentRepository->create([
                'provider' => 'gumroad',
                'provider_payment_id' => $data['sale_id'],
                'user_id' => $user?->id,
                'amount' => $data['price'],
                'currency' => 'usd',
                'status' => 'paid',
                'paid_at' => now(),
                'meta_json' => $data,
            ]);


            // 3. sauvegarder achat
            $this->purchaseRepository->create([
                'user_id' => $user?->id,
                'payment_id' => $payment->id,
                'product_type' => CreditPlan::class,
                'product_id' => $data['product_id'],
                'status' => 'paid',
                'amount' => $data['price'],
                'currency' => 'usd',
                'product_snapshot_json' => [
                    'product_name' => $data['product_name'],
                ],
                'purchased_at' => now(),
            ]);

            $plan = $this->creditPlanRepository->findByField('provider_product_id', $data['product_id']);
            // snapshot pricing
            $snapshot = [
                'plan' => $plan->name,
                'credits' => $plan->credits,
                'price' => $plan->price,
            ];

            $this->addCredits(
                $user->id,
                $plan->credits,
                $payment->id,
                $snapshot
            );
        });

        $user = User::where('email', $data['email'])->first();
        $token = $user->createToken('api-token')->plainTextToken;
        return redirect("http://localhost:5173/payement/callback?token={$token}");
    }

    public function simulateWebhook(Request $request)
    {
        Log::info("simualation") ;
        $data = ['sale_id'=> (string) Str::uuid() ,
        'email' => 'harry.kouevi@gmail.com' ,
        'price' => 12,
        "name" => "Best for testing",
        "product_name" => "Best for testing",
        'product_id'=> 'rEdud1H-KnisLY1-f9TqTA==' ,
        ] ;

        $existingPayment = $this->paymentRepository->findByField( 'provider_payment_id', $data['sale_id'])->first() ;
        if ($existingPayment && $existingPayment->status === 'paid') {
            return;
        }

        DB::transaction(function () use ($data) {



            $user = User::where('email', $data['email'])->first();

            $payment = $this->paymentRepository->create([
                'provider' => 'gumroad',
                'provider_payment_id' => $data['sale_id'],
                'user_id' => $user?->id,
                'amount' => $data['price'],
                'currency' => 'usd',
                'status' => 'paid',
                'paid_at' => now(),
                'meta_json' => $data,
            ]);

            $plan = $this->creditPlanRepository->findByField('provider_product_id', $data['product_id'])->first();

            log::info($plan ) ;

            // 3. sauvegarder achat
            $this->purchaseRepository->create([
                'user_id' => $user?->id,
                'payment_id' => $payment->id,
                'product_type' => CreditPlan::class,
                'product_id' => $plan->id,
                'status' => 'paid',
                'amount' => $data['price'],
                'currency' => 'usd',
                'product_snapshot_json' => [
                    'product_name' => $data['product_name'],
                ],
                'purchased_at' => now(),
            ]);
            log::info('pueshaqe' ) ;

            // snapshot pricing
            $snapshot = [
                'plan' => $plan->name,
                'credits' => $plan->credits > 0 ? $plan->credits : 20,
                'price' => $plan->price,
            ];

            $this->addCredits(
                $user->id,
                $plan->credits > 0 ? $plan->credits : 20,
                $payment->id,
                $snapshot
            );
        });


        $user = User::where('email', $data['email'])->first();
        // loadProfileData();
        // new UserProfileResource($user)
        $token = $user->createToken('api-token')->plainTextToken;
        return redirect("http://localhost:5173/payement/callback?token={$token}");

    }

    private function addCredits(
        int $userId,
        int $credits,
        ?int $paymentId = null,
        array $snapshot = []
    )
    {
        DB::transaction(function () use (
            $userId,
            $credits,
            $paymentId,
            $snapshot
        ) {
            $wallet = $this->creditRepository->findByField('user_id', $userId)->first();
            log::info('walet' ) ;

            if (!$wallet) {
                $wallet = $this->creditRepository->create([
                    'user_id' => $userId,
                    'balance' => 0,
                    'used' => 0,
                    'purchased_total' => 0,
                ]);
            }

            $newBalance = $wallet->balance + $credits;

            $wallet = $this->creditRepository->update([
                'balance' => $newBalance,
                'purchased_total' => $wallet->purchased_total + $credits,
            ],$wallet->id);

            log::info('walet update' ) ;

            $this->creditTransactionRepository->create([
                'user_id' => $userId,
                'payment_id' => $paymentId,
                'type' => 'purchase',
                'credits' => $credits,
                'balance_after' => $newBalance,
                'snapshot_json' => $snapshot,
                'description' => 'Credit purchase',
                // 'pricing_snapshot_json' => json_encode($snapshot),

            ]);

            log::info('transaction' ) ;

        });
    }


}
