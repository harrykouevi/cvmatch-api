<?php

namespace App\Repositories\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CreditPlanRepository
 *
 * @package namespace App\Repositories;
 */
interface CreditPlanRepository extends RepositoryInterface
{
    /**
     * Retrieve data array for populate field select
     *
     * @param string $column
     * @param array $paddleProductIds
     * @param string $provider
     */
    public function deleteWhereNotIn(
            string $column,
            array $paddleProductIds,
            string $provider
        );
}
