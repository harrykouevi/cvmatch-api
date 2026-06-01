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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;


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
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        // =====================================================
        // 1. VERIFY STRIPE SIGNATURE
        // =====================================================
        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Exception $e) {
            Log::error('Stripe webhook invalid signature', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // =====================================================
        // 2. ONLY HANDLE REQUIRED EVENT
        // =====================================================
        if ($event->type !== 'checkout.session.completed') {
            return response()->json(['message' => 'Event ignored']);
        }

        // =====================================================
        // 3. EXTRACT SESSION
        // =====================================================
        $session = $event->data->object;

        $paymentIntentId = $session->payment_intent ?? null;
        $email = $session->customer_details->email ?? null;

        if (!$paymentIntentId || !$email) {
            return response()->json([
                'error' => 'Missing payment intent or email'
            ], 400);
        }

        // =====================================================
        // 4. FIND USER
        // =====================================================
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::warning('Stripe webhook: user not found', [
                'email' => $email
            ]);

            return response()->json(['error' => 'User not found'], 404);
        }

        // =====================================================
        // 5. IDEMPOTENCY CHECK (avoid double processing)
        // =====================================================
        $existing = $this->paymentRepository
            ->findByField('provider_payment_id', $paymentIntentId)
            ->first();

        if ($existing && $existing->status === 'paid') {
            return response()->json(['message' => 'Already processed']);
        }

        // =====================================================
        // 6. PROCESS PAYMENT (DB TRANSACTION SAFE)
        // =====================================================
        DB::transaction(function () use ($session, $paymentIntentId, $user, $event) {

            // Stripe amount is in cents
            $amount = ($session->amount_total ?? 0) / 100;

            // Create payment record
            $payment = $this->paymentRepository->create([
                'provider' => 'stripe',
                'provider_payment_id' => $paymentIntentId,
                'user_id' => $user->id,
                'amount' => $amount,
                'currency' => strtolower($session->currency ?? 'usd'),
                'status' => 'paid',
                'paid_at' => now(),
                'meta_json' => json_decode(json_encode($event), true),
            ]);

            // =================================================
            // 7. GET STRIPE LINE ITEMS
            // =================================================
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            $items = [];

            try {
                $items = $stripe->checkout->sessions->allLineItems(
                    $session->id
                )->data;
            } catch (\Exception $e) {
                Log::error('Stripe line items error', [
                    'error' => $e->getMessage()
                ]);
            }

            // =================================================
            // 8. PROCESS ITEMS → CREDITS
            // =================================================
            foreach ($items as $item) {

                $priceId = $item->price->id ?? null;

                if (!$priceId) {
                    continue;
                }

                $plan = $this->creditPlanRepository
                    ->findByField('provider_price_id', $priceId)
                    ->first();

                if (!$plan) {
                    Log::warning('Stripe webhook: plan not found', [
                        'price_id' => $priceId
                    ]);
                    continue;
                }

                // Create purchase
                $this->purchaseRepository->create([
                    'user_id' => $user->id,
                    'payment_id' => $payment->id,
                    'product_type' => CreditPlan::class,
                    'product_id' => $plan->id,
                    'status' => 'paid',
                    'amount' => $amount,
                    'currency' => strtolower($session->currency ?? 'usd'),
                    'product_snapshot_json' => [
                        'product_name' => $plan->name,
                        'credits' => $plan->credits,
                        'price' => $plan->price,
                    ],
                    'purchased_at' => now(),
                ]);

                // Add credits
                $this->addCredits(
                    $user->id,
                    $plan->credits,
                    $payment->id,
                    [
                        'plan' => $plan->name,
                        'credits' => $plan->credits,
                        'price' => $plan->price,
                    ]
                );
            }
        });

        // =====================================================
        // 9. SUCCESS RESPONSE
        // =====================================================
        return response()->json(['status' => 'success']);
    }


    public function createStripeSession(Request $request)
    {

        $user = Auth::user() ;
        if (!$user) {
            return $this->sendError('User not authenticated', 401);
        }

        $this->validate($request, [
            'product_id' => 'required',
        ]);

        $productId = $request->product_id;
        $product = $this->creditPlanRepository->find( $productId );
        Log::info($product) ;
        if (!$product) {
            $this->sendError("Product not found", 404);
        }

        Stripe::setApiKey(config("services.stripe.secret"));

        $session = Session::create([
            "payment_method_types" => ["card"],
            "mode" => "payment",

            "line_items" => [[
                "price_data" => [
                    "currency" => "usd",
                    "product_data" => [
                        "name" => $product["name"],
                    ],
                    "unit_amount" => $product["price"],
                ],
                "quantity" => 1,
            ]],

            "metadata" => [
                "product_id" => $product["id"],
                "credits" => $product["credits"],
                'user_currency' => "usd",
            ],

            "success_url" => "https://cvmatchai.us/payment/success?session_id={CHECKOUT_SESSION_ID}",
            "cancel_url" => "https://cvmatchai.us/payment/cancel",
        ]);



        return $this->sendResponse([
            "session_id" => $session->id,
            "url" => $session->url
        ], __('lang.saved_successfully', ['operator' => __('lang.session_stripe')]));

    }


    public function redirectToGumroad(Request $request)
    {
        $data = $request->all();
        $paylink = $data['link'] ?? null;
        return redirect("{$paylink}?wanted=true ");
    }

    public function createPaddleCheckout(Request $request)
    {
        $request->validate([ 'price_id' => 'required|string']);
        $user = $request->user();
        $priceId = $request->price_id;

        // sécurité : vérifier que le prix existe vraiment
        // $allowedPrices = [
        //     'pri_01hxxxxx',
        //     'pri_01hyyyyy',
        // ];

        // if (!in_array($priceId, $allowedPrices)) {
        //     return response()->json([
        //         'message' => 'Invalid price'
        //     ], 403);
        // }

        $response = Http::withToken(config('services.paddle.api_key'))
            ->post('https://api.paddle.com/transactions', [
                'items' => [
                    [
                        'price_id' => $request->price_id,
                        'quantity' => 1
                    ]
                ],

                'customer_email' => $user->email,
                "collection_mode" => "automatic",

                'custom_data' => [
                    'user_id' => $user->id,
                    'plan' => $request->plan_name,
                ],

                'checkout' => [
                    'url' => route('paddle.success')
                ]
            ]);

        if (!$response->successful()) {
            return response()->json([
                "message" => "Paddle transaction creation failed",
                "error" => $response->json()
            ], 500);
        }

        $data = $response->json();

        return response()->json([
            'checkout_url' => $data['data']['checkout']['url'] ?? null,
            "transaction_id" => $data["data"]["id"] ?? null,
        ]);
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
        return redirect("https://cvmatchai.us/payement/callback?token={$token}");
    }

    public function handlePAddleWebhook(Request $request)
    {
        // $data = $request->all();
        // $saleId = $data['sale_id'] ?? null;

        // $user = User::where('email', $data['email'])->first();
        // $token = $user->createToken('api-token')->plainTextToken;

        // if (!$saleId) {
        //     return response()->json(['error' => 'Missing sale_id'], 400);
        // }

        // =========================
        // RAW BODY
        // =========================
        $payload = $request->getContent();
        $signature = $request->header('Paddle-Signature');

        // =========================
        // VERIFY SIGNATURE
        // =========================
        try {
            $secret = config('services.paddle.webhook_secret');
            if (!$signature) {
                return response()->json([
                    'error' => 'Missing signature'
                ], 400);
            }
            $data = json_decode($payload, true);

        } catch (\Exception $e) {
            Log::error('Paddle webhook signature invalid', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Invalid signature'
            ], 400);
        }


        $eventType = $data['event_type'] ?? null;

        // =========================
        // ONLY transaction.completed
        // =========================
        if ($eventType !== 'transaction.completed') {
            return response()->json([
                'message' => 'Event ignored'
            ]);
        }

        // =========================
        // TRANSACTION DATA
        // =========================
        $transaction = $data['data'] ?? null;

        if (!$transaction) {
            return response()->json([
                'error' => 'Missing transaction data'
            ], 400);
        }

        $transactionId = $transaction['id'] ?? null;

        if (!$transactionId) {
            return response()->json([
                'error' => 'Missing transaction id'
            ], 400);
        }

        $email = $transaction['customer']['email'] ?? null;
        if (!$email) {
            return response()->json([
                'error' => 'Missing customer email'
            ], 400);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::warning('User not found for Paddle payment', [
                'email' => $email
            ]);

            return response()->json([
                'error' => 'User not found'
            ], 404);
        }


        $items = $transaction['items'] ?? [];

        if (empty($items)) {
            return response()->json([
                'error' => 'No items'
            ], 400);
        }

        DB::transaction(function () use (
            $transaction,
            $transactionId,
            $items,
            $user,
            $data
        ) {


            $existingPayment = $this->paymentRepository->findByField( 'provider_payment_id',  $transactionId)->first() ;
            if ($existingPayment && $existingPayment->status === 'paid') {
                return;
            }


            $amount = $transaction['details']['totals']['grand_total'] ?? 0;
            $amount = $amount / 100;

            $payment = $this->paymentRepository->create([
                'provider' => 'paddle',
                'provider_payment_id' => $transactionId,
                'user_id' => $user?->id,
                'amount' => $amount,
                'currency' => strtolower( $transaction['currency_code'] ?? 'usd'),
                'status' => 'paid',
                'paid_at' => now(),
                'meta_json' => $data,
            ]);

            // =========================
            // PROCESS ITEMS
            // =========================
            foreach ($items as $item) {

                $priceId = $item['price']['id'] ?? null;
                if (!$priceId) {
                    continue;
                }

                $plan = $this->creditPlanRepository
                        // ->findByField('provider_product_id', $data['product_id']);
                        ->findByField('provider_price_id', $priceId)
                    ->first();

                if (!$plan) {
                    Log::warning('Plan not found', [
                        'price_id' => $priceId
                    ]);
                    continue;
                }

                // 3. sauvegarder achat
                $this->purchaseRepository->create([
                    'user_id' => $user?->id,
                    'payment_id' => $payment->id,
                    'product_type' => CreditPlan::class,
                    'product_id' => $data['product_id'],
                    'status' => 'paid',
                    'amount' => $amount,
                    'currency' => 'usd',
                    'product_snapshot_json' => [
                        'product_name' => $plan->name,
                        'credits' => $plan->credits,
                        'price' => $plan->price,
                    ],
                    'purchased_at' => now(),
                ]);

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
            }
        });

        // $user = User::where('email', $data['email'])->first();
        // $token = $user->createToken('api-token')->plainTextToken;
        // return redirect("http://localhost:5173/payement/callback?token={$token}");
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
