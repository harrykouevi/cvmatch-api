<?php

namespace App\Services;

use App\Repositories\Interfaces\CreditPlanRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PaddleProductService
{
    private Client $client;

     /** @var CreditPlanRepository */
    private CreditPlanRepository $creditPlanRepository;


    public function __construct( CreditPlanRepository $creditPlanRepository)
    {
        $this->client = new Client([
            'base_uri' => config('services.paddle.base_url'),
            'timeout' => 90,
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.paddle.api_key'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->creditPlanRepository = $creditPlanRepository;
    }

    public function syncCreditPlansPaddle()
    {
        Log::info('sync from paddle');
        $products = $this->listProducts(['include' => 'prices']);
        if (empty($products)) {
            Log::warning('No products found from paddle');
            return ;
        }

        /**
         * 1. Construire les IDs Paddle existants
         */
        $paddleProductIds = [];
        $paddlePriceIds = [];

        foreach ($products as $product) {
            $paddleProductIds[] = $product['id'];

            if (!empty($product['prices'])) {
                foreach ($product['prices'] as $price) {
                    $paddlePriceIds[] = $price['id'];
                }
            }
        }

        $paddleProductIds = array_unique($paddleProductIds);
        $paddlePriceIds = array_unique($paddlePriceIds);



        $synced = [];



        foreach ($products as $product) {

            // si pas de prix, tu peux soit skip soit créer un record sans price
            if (empty($product['prices'])) {
                $synced[] = $this->creditPlanRepository->updateOrCreate(
                    [
                        'provider' => 'paddle',
                        'provider_product_id' => $product['id'],
                        'provider_price_id' => null,
                    ],
                    [
                        'name' => $product['name'],
                        'price' => 0001,
                        'currency' => 'usd',
                        'provider_product_snapshot_json' => json_encode($product),
                        'is_active' => $product['status'] === 'active',
                        'synced_at' => now(),
                    ]
                );

                continue;
            }
            foreach ($product['prices'] as $price) {
                $synced[] = $this->creditPlanRepository->updateOrCreate(
                    [
                        'provider' => 'paddle',
                        'provider_product_id' => $product['id'],
                        'provider_price_id' => $price['id'],
                    ],
                    [
                        'name' => $product['name'],
                        'price' => $price['unit_price']['amount'] ?? 0,
                        'currency' => $price['unit_price']['currency_code'] ?? 'usd',
                        'provider_product_snapshot_json' => json_encode($product),
                        'is_active' => $product['status'] === 'active' && ($price['status'] ?? 'a') === 'active',
                        'synced_at' => now(),
                    ]
                );
            }
        }

        /**
         * 3. SUPPRESSION des produits qui n'existent plus chez Paddle
         */

        // a) supprimer produits orphelins
        $this->creditPlanRepository->deleteWhereNotIn(
            'provider_product_id',
            $paddleProductIds,
            'paddle'
        );

        // b) supprimer prix orphelins
        $this->creditPlanRepository->deleteWhereNotIn(
            'provider_price_id',
            $paddlePriceIds,
            'paddle'
        );


        // return $synced;
    }

    private function listProducts(array $query = [])
    {
        try {

            $response = $this->client->get('/products', [
                'query' => $query,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            Log::info(' fetching products from Paddle');

            return $data['data'] ?? [];

        } catch (\Throwable $e) {
            Log::error('Error fetching products from Paddle', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }
}
