<?php

namespace App\Services\Providers;

interface CreditPlanProviderInterface
{
    public function sync(): void;
}
