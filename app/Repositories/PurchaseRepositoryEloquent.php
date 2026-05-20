<?php

namespace App\Repositories;

use App\Models\Purchase;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PurchaseRepository ;
use App\Validators\PurchaseValidator;

/**
 * Class PurchaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PurchaseRepositoryEloquent extends BaseRepository implements PurchaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Purchase::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
