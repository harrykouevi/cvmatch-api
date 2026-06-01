<?php

namespace App\Services;

use App\Repositories\Interfaces\CreditPlanRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GumroadProductService
{
    private Client $client;
    private string $apiKey;

     /** @var CreditPlanRepository */
    private CreditPlanRepository $creditPlanRepository;


    public function __construct( CreditPlanRepository $creditPlanRepository)
    {
        $this->client = new Client([
            // 'base_uri' => '',
            'timeout' => 90,
        ]);

        $this->creditPlanRepository = $creditPlanRepository;
    }

    public function syncCreditPlansFromGumroad()
    {
        Log::info('sync from Gumroad');
        $products = $this->listProducts();
        if (empty($products)) {
            Log::warning('No products found from Gumroad');
            return ;
        }

        $ProductIds = [];
        $PriceIds = [];

        foreach ($products as $product) {
            $ProductIds[] = $product['id'];
        }
        $ProductIds = array_unique($ProductIds);


        $synced = [];



        foreach ($products as $product) {

            $synced[] = $this->creditPlanRepository->updateOrCreate(
                [
                    'provider' => 'gumroad',
                    'provider_product_id' => $product['id'],
                ],
                [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'currency' => $product['currency'] ?? 'usd',
                    'provider_product_snapshot_json' => json_encode($product),
                    'is_active' => $product['published'] ?? false,
                    'synced_at' => now(),
                ]
            );
        }

        /**
         * 3. SUPPRESSION des produits qui n'existent plus chez gumroad
         */

        // a) supprimer produits orphelins
        $this->creditPlanRepository->deleteWhereNotIn(
            'provider_product_id',
            $ProductIds,
            'gumroad'
        );

        // return $synced;
    }

    private function listProducts()
    {
        try {
            $response = $this->client->get('https://api.gumroad.com/v2/products', [
                'query' => [
                    'access_token' => config('services.gumroad.token'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            Log::info(' fetching products from Gumroad');

            return $data['products'] ?? [];

        } catch (\Throwable $e) {
            Log::error('Error fetching products from Gumroad', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }
}
