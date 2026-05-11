<?php

namespace App\Repositories;

use App\Models\CreditTransaction;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\CreditTransactionRepository ;
use App\Validators\CreditTransactionValidator;

/**
 * Class CreditTransactionRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class CreditTransactionRepositoryEloquent extends BaseRepository implements CreditTransactionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CreditTransaction::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
