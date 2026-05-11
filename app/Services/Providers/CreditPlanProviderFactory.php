<?php

namespace App\Services\Providers;

class CreditPlanProviderFactory
{
    public function make(string $provider): CreditPlanProviderInterface
    {
        return match ($provider) {
            'gumroad' => app(GumroadProductProvider::class),
            // 'stripe' => app(StripeCreditPlanProvider::class),

            default => throw new \Exception("Unknown provider: {$provider}")
        };
    }
}
