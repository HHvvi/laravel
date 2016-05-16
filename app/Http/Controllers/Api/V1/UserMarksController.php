<?php

namespace App\Http\Controllers\Api\V1;

use Validator;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\UserMarkRepositoryEloquent as UserMarkRepository;
use App\Http\Requests\UserMarkUpdateRequest;
use App\Validators\UserMarkValidator;
use App\Http\Requests\V1\UserMarkCreateRequest;


class UserMarksController extends BaseController
{
    protected $repository;

    public function __construct(UserMarkRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @api            {post} /user/mark  添加个人标签
     * @apiDescription 添加个人标签(signup)
     * @apiGroup       User
     * @apiUse         Validation
     * @apiPermission  jwt
     * @apiVersion     0.1.0
     * @apiParam {String} mark   标签
     * @apiParamExample {json} Request-Example:
     *     {
     *       "mark": 1,2,3,
     *     }
     * @apiSuccess {String} token  用于验证
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         success: true
     *     }
     * @apiErrorExample {json} Error-Response:
     *      HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "422 Unprocessable Entity"
     *       "errors": {
     *          "mark": [
     *              "请选择标签"
     *                      ]
     *                  },
     *       "status_code": 422,
     *     }
     */
    public function store(UserMarkCreateRequest $request)
    {
        $data['mark'] = explode(',', $request['mark']);

        $validator = Validator::make($data, [
            'mark' => 'required|array',
            'mark.*' => 'required|integer|exists:ac_mark,mark_id',
        ],[],[
            'mark' => '标签',
            'mark.*' => '标签'
        ]);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('422 Unprocessable Entity', $validator->errors());
        }
        $uid = $this->Uid();

        array_walk($data['mark'],function(&$value,$key,$uid){
            $value = ['mark_id' =>$value,'user_guid'=>$uid];
            $this->repository->create($value);
        },$uid);

        return ['success' => true];
    }

    public function userMarkValid($uid){
        $userMark = $this->repository->findWhere([
            'user_guid' => $uid
        ]);

        if (empty($userMark['attributes'])){
            return false;
        }
        return true;
    }
}
