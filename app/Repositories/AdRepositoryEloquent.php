<?php

namespace App\Repositories;

use App\Repositories\Criteria\AdCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Interfaces\AdRepository;
use App\Models\Ad;
use App\Validators\AdValidator;

/**
 * Class AdRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AdRepositoryEloquent extends BaseRepository implements AdRepository
{
    protected $fieldSearchable = [
        'title'=>'like',
        'content'=>'like'
    ];


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ad::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AdValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(AdCriteria::class));
    }

    public function presenter()
    {
        return "App\\Presenters\\AdPresenter";
    }
}
