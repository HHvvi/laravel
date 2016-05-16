<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth,Validator;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepositoryEloquent  as UserRepository;
use App\Validators\UserValidator;


class UsersController extends BaseController
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;


    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $users = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $users,
            ]);
        }

        return view('users.index', compact('users'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $user,
            ]);
        }

        return view('users.show', compact('user'));
    }



    /**
     *
     * @api            {put} /user 修改个人资料
     * @apiVersion     0.1.0
     * @apiName        updateUser
     * @apiDescription 修改个人资料
     * @apiGroup       User
     * @apiUse         Validation
     * @apiPermission  jwt
     * @apiParam {number=1,2} [sex]   性别
     * @apiParam {String} [bornDate]   生日(格式为2016-05-05)
     * @apiParam {number{1-300}} [height]   身高
     * @apiParam {number{1-300}} [weight]   体重
     * @apiParamExample {json} Request-Example:
     *     [
     *       "sex": 1
     *       "bornDate": 2015-12-04
     *       "height": 180
     *       "weight": 80
     *     ]
     * @apiError       StoreResourceFailed 请填写正确的资料.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     [
     *       "message": "请填写正确的资料",
     *       "errors": {
     *          "sex": [
     *              "请填写正确的性别"
     *                  ],
     *          "bornDate": [
     *              "生日不能大于今日。"
     *                  ]
     *                 },
     *       "status_code": 422,
     *     ]
     *
     */
    public function update(UserUpdateRequest $request)
    {
        $req = $request->all();
        $req = field_map($this->repository->map,array_intersect_key($req,$request->rules()));
        $user = $this->repository->update($req, $this->Uid());
        return $user;
    }
    
}
