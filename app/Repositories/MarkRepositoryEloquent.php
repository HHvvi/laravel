<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\MarkRepository;
use App\Models\Mark;
use App\Validators\MarkValidator;

/**
 * Class MarkRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MarkRepositoryEloquent extends BaseRepository implements MarkRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Mark::class;
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
        return "App\\Presenters\\MarkPresenter";
    }
}
