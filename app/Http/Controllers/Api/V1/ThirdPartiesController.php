<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\ThirdPartyRepositoryEloquent as ThirdPartyRepository;


class ThirdPartiesController extends BaseController
{
    protected $repository;

    public function __construct(ThirdPartyRepository $repository)
    {
        $this->repository = $repository;
    }


    public function checkThirdpartyValid($openID){

        $thirdParty = $this->repository->skipPresenter()->findWhere([
            'user_auth_id' => $openID
        ])->first();

        if (empty($thirdParty['attributes'])){
            return false;
        }
        return $thirdParty;
    }

}
