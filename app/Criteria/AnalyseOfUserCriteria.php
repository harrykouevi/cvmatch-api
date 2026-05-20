<?php
/*
 * File name: AnalyseOfUserCriteria.php
 * Last modified: 2024.04.18 at 18:21:47
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace App\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AnalyseOfUserCriteria.
 *
 * @package namespace App\Criteria\Bookings;
 */
class AnalyseOfUserCriteria implements CriteriaInterface
{
    /**
     * @var ?int
     */
    private int $userId;

    /**
     * AnalyseOfUserCriteria constructor.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {

            return $model->where('user_id', $this->userId);


    }
}
