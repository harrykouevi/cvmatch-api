<?php

namespace App\Repositories;

use App\Models\Resume;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\ResumeRepository;

/**
 * Class ResumeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ResumeRepositoryEloquent extends BaseRepository implements ResumeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Resume::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
