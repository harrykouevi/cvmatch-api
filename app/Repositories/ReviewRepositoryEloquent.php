<?php

namespace App\Repositories;

use App\Models\Review;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\ReviewRepository ;
use App\Validators\ReviewValidator;

/**
 * Class ReviewRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReviewRepositoryEloquent extends BaseRepository implements ReviewRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Review::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
