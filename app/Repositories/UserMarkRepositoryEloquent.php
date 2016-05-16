<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\UserMarkRepository;
use App\Models\UserMark;
use App\Validators\UserMarkValidator;

/**
 * Class UserMarkRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserMarkRepositoryEloquent extends BaseRepository implements UserMarkRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserMark::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserMarkValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
