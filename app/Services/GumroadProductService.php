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

        $this->apiKey = config('services.openai.key');
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

        // return $synced;
    }

    private function extractCredits(array $product): int
    {
        return match ($product['price']) {
            1000 => 100,
            2000 => 250,
            5000 => 700,
            default => 0,
        };
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
