<?php

namespace App\Repositories;

use App\Models\MobileWait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\MobileWaitRepository ;
use App\Validators\MobileWaitValidator;

/**
 * Class MobileWaitRepositoryEloquent
 *
 * @package namespace App\Repositories;
 */
class MobileWaitRepositoryEloquent extends BaseRepository implements MobileWaitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MobileWait::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
