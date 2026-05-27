<?php

namespace App\Repositories;

use App\Models\CreditPlan;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\CreditPlanRepository ;
use App\Validators\CreditPlanValidator;

/**
 * Class CreditPlanRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class CreditPlanRepositoryEloquent extends BaseRepository implements CreditPlanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CreditPlan::class;
    }

    public function deleteWhereNotIn(string $field, array $values, string $provider)
    {
        return CreditPlan::where('provider', $provider)
            ->whereNotIn($field, $values)
            ->delete();
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
