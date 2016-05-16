<?php

namespace App\Repositories;

use App\Repositories\Criteria\ActivityCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ActivityRepository;
use App\Models\Activity;
use App\Validators\ActivityValidator;

/**
 * Class ActivityRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ActivityRepositoryEloquent extends BaseRepository implements ActivityRepository
{
    protected $fieldSearchable = [
        'activity_title'=>'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Activity::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ActivityValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(ActivityCriteria::class));
    }


    public function presenter()
    {
        return "App\\Presenters\\ActivityPresenter";
    }
}
