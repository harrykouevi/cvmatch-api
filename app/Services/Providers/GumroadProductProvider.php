<?php

namespace App\Services\Providers;

use App\Services\GumroadProductService;

class GumroadProductProvider implements CreditPlanProviderInterface
{
    public function __construct(
        protected GumroadProductService $service
    ) {}

    public function sync(): void
    {
        $this->service->syncCreditPlansFromGumroad();
    }
}
