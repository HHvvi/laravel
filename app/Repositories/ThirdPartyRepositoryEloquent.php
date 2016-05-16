<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\ThirdPartyRepository;
use App\Models\ThirdParty;
use App\Validators\ThirdPartyValidator;

/**
 * Class ThirdPartyRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ThirdPartyRepositoryEloquent extends BaseRepository implements ThirdPartyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ThirdParty::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ThirdPartyValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


}
