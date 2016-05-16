<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\DefaultIconRepository;
use App\Models\DefaultIcon;
use App\Validators\DefaultIconValidator;

/**
 * Class DefaultIconRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DefaultIconRepositoryEloquent extends BaseRepository implements DefaultIconRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DefaultIcon::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return DefaultIconValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return "App\\Presenters\\DefaultIconPresenter";
    }
}
