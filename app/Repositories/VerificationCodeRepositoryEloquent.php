<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\VerificationCodeRepository;
use App\Models\VerificationCode;
use App\Validators\VerificationCodeValidator;

/**
 * Class SmsVerificationCodeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VerificationCodeRepositoryEloquent extends BaseRepository implements VerificationCodeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VerificationCode::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return VerificationCodeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function validation($data){
        $verification = $this->findWhere(['to' => $data['account']])->first();
        if (empty($verification)||$verification['attributes']['sent_time']+config('custom.expiration.time')< time()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('422 Unprocessable Entity', ['verification'=>['验证码过期，请重新获取']]);
        }
    }
}
