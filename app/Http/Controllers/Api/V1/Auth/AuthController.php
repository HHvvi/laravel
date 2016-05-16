<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-13
 * Time: 下午12:36
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\Api\V1\ThirdPartiesController;
use App\Http\Controllers\Api\V1\UploadController;
use App\Http\Controllers\Api\V1\UserMarksController;
use App\Http\Requests\V1\UserCreateRequest;
use App\Http\Requests\V1\UserLoginRequest;
use App\Repositories\VerificationCodeRepositoryEloquent as VerificationCodeRepository;
use App\Repositories\UserRepositoryEloquent as UserRepository;
use Dingo\Api\Http\Request;
use JWTAuth,Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends BaseController
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @api            {post} /auth/signin 登录(signin)
     * @apiDescription 登录(signin)
     * @apiGroup       Auth
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiParam {String} account   帐号
     * @apiParam {String} password  md5(密码)
     * @apiParamExample {json} Request-Example:
     *     {
     *       "account": 15018690606,
     *       "password": be95edb69d202388a7817b54e0194f7b
     *     }
     * @apiVersion     0.1.0
     * @apiSuccess {String} token  用于验证
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY
     *         userMarkValid:
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "登录失败"
     *       "errors": {
     *          "account": [
     *              "帐号不能为空。"
     *                      ]
     *                  },
     *       "status_code": 422,
     *     }
     *     HTTP/1.1 412 Precondition Failed
     *     {
     *       "message": "请选择个人标签"
     *       "status_code": 412,
     *     }
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "message": "帐号或密码错误",
     *       "status_code": 401,
     *     }
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *       "message": "认证服务器错误，请稍后重试",
     *       "status_code": 500,
     *     }
     */
    public function login(UserLoginRequest $request,UserMarksController $userMark)
    {
        $credentials = $request->only('account', 'password');
        try {
            $user = $this->attempt($credentials);

            $userMarkValid = $userMark->userMarkValid($user['attributes']['user_guid']);

            $token = JWTAuth::fromUser((object)$user['attributes']);
            return compact('token','userMarkValid');
        } catch (JWTException $e) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, '认证服务器错误，请稍后重试');
        }
    }

    public function attempt($credentials)
    {
        $user = $this->repository->skipPresenter()->findWhere([
            'user_account' => $credentials['account']
        ])->first();

        if (encrypt_pwd($credentials['password'], $user['attributes']['salt']) != $user['attributes']['pwd']) {
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('login', '帐号或密码错误');
        }
        return $user;
    }

    /**
     * @api            {post} /auth/token/refresh 刷新token(refresh token)
     * @apiDescription 刷新token(refresh token)
     * @apiGroup       Auth
     * @apiPermission  JWT
     * @apiUse         Validation
     * @apiVersion     0.1.0
     * @apiHeader {String} Authorization 用户过期的token, value已Bearer开头
     * @apiSuccess {String} token  用于验证
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         token: 9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "UserNotFound"
     *     }
     */
    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();
        return compact('token');
    }

    /**
     * @api            {post} /auth/signup 注册(signup)
     * @apiDescription 注册(signup)
     * @apiGroup       Auth
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiVersion     0.1.0
     * @apiParam {String} account   帐号
     * @apiParam {String} password   密码(需要md5加密)
     * @apiParam {String} logo   用户自定义头像KEY
     * @apiParam {String} defaultLogo   默认头像URL(默认为空格)
     * @apiParam {String{2-10}} name   昵称
     * @apiParam {Number} verification   验证码
     * @apiParamExample {json} Request-Example:
     *     {
     *       "account": 15018690606,
     *       "password": be95edb69d202388a7817b54e0194f7b
     *       "logo": '645646456'
     *       "defaultLogo": '645646456'
     *       "name": '我叫名字'
     *       "verification": '123456'
     *     }
     * @apiSuccess {String} token  用于验证
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY
     *     }
     * @apiErrorExample {json} Error-Response:
     *      HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "422 Unprocessable Entity"
     *       "errors": {
     *          "account": [
     *              "帐号不能为空。"
     *                      ]
     *                  },
     *       "status_code": 422,
     *     }
     */
    public function signup(UserCreateRequest $request, VerificationCodeRepository $verificationRepository)
    {
        $req = $request->all();
        if (preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i", $req['account'])) {
            $user = [
                'email' => $req['account']
            ];
        } else {
            $user = [
                'mobile' => $req['account']
            ];
        }

        $verificationRepository->validation($req);

        $user['user_guid'] = create_guid();
        $user['user_account'] = $req['account'];
        $user['nick_name'] = $req['name'];
        $user['logo'] = explode(config('custom.img_reduce.img_separator'), $req['defaultLogo'], -1)[0];
        if ($req['logo']!=" ") {
            $data['key'] = $req['logo'];
            $data['module'] = 'user';
            $upload = new UploadController;
            $user['logo'] = config('custom.url.open_img').$upload->positiveImg($data);
        }
        $user['salt'] = mt_rand(10000, 99999);
        $user['pwd'] = encrypt_pwd($req['password'], $user['salt']);
        $user = $this->repository->create($user);
        $token = JWTAuth::fromUser($user);
        return compact('token');
    }



    /**
     * @api            {post} /auth/thirdparty 第三方登录
     * @apiDescription 第三方登录
     * @apiGroup       Auth
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiVersion     0.1.0
     * @apiParam {String} platform   第三方平台
     * @apiParam {String} openCode   openID
     * @apiParam {Array[]} openInfo   第三方回调信息
     * @apiParamExample {json} Request-Example:
     *     {
     *       "account": 15018690606,
     *       "password": be95edb69d202388a7817b54e0194f7b
     *       "logo": '645646456'
     *       "defaultLogo": '645646456'
     *       "name": '我叫名字'
     *       "verification": '123456'
     *     }
     */
    public function thirdParty(Request $request,ThirdPartiesController $thirdParty,UserMarksController $userMark){
//        Log::info('第三方登录: '.json_encode($request->all()));
        $req = $request->all();

        if (!$thirdUser = $thirdParty->checkThirdpartyValid($req['openCode'])){
            throw  new  \Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException('CompletionUserInfo');
        };

        $user = $this->repository->skipPresenter()->findWhere([
            'user_guid' => $thirdUser['user_guid']
        ])->first();

        $userMarkValid = $userMark->userMarkValid($user['attributes']['user_guid']);

        $token = JWTAuth::fromUser((object)$user['attributes']);
        return compact('token','userMarkValid');
    }

}