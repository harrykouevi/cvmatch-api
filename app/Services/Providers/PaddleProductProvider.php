<?php

namespace App\Services\Providers;

use App\Services\PaddleProductService;

class PaddleProductProvider implements CreditPlanProviderInterface
{
    public function __construct(
        protected PaddleProductService $service
    ) {}

    public function sync(): void
    {
        $this->service->syncCreditPlansPaddle();
    }
}
