<?php

namespace App\Repositories;

use App\Models\Analyse;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\AnalyseRepository ;
use App\Validators\AnalyseValidator;

/**
 * Class AnalyseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AnalyseRepositoryEloquent extends BaseRepository implements AnalyseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Analyse::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
