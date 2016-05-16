<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-25
 * Time: 上午11:00
 */

namespace App\Http\Controllers\Api\V1;

use App\Events\SendEmailEvent;
use App\Events\SendSmsEvent;
use App\Http\Requests\V1\EmailVerificationCodeCreateRequest;
use App\Http\Requests\V1\SmsVerificationCodeCreateRequest;
use App\Repositories\VerificationCodeRepositoryEloquent as VerificationCodeRepository;
use App\Validators\VerificationCodeValidator;
use Cloud;
use Prettus\Validator\Exceptions\ValidatorException;


class SendController extends BaseController
{
    protected $repository;
    protected $validator;

    public function __construct(VerificationCodeRepository $repository, VerificationCodeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @api            {post} /send/sms 发送短信
     * @apiVersion     0.1.0
     * @apiName        sendSMS
     * @apiDescription 发送短信
     * @apiGroup       Other
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiParam {Number}  account   手机号码[unique]
     * @apiParamExample {json} Request-Example:
     *     {
     *       "account": 15018690606
     *     }
     * @apiSuccess {Boolean} success  是否成功
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         success: true
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "发送失败"
     *       "errors": {
     *          "account": [
     *              "号码已注册，请登录。"
     *                      ]
     *                  },
     *       "status_code": 422,
     *     }
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *       "message": "发送失败，请稍后重试",
     *       "status_code": 500,
     *     }
     */
    public function sms(SmsVerificationCodeCreateRequest $request)
    {
        $data = $request->only('account');
        $verification = $this->repository->findWhere(['to' => $data['account']])->first();
        if (empty($verification)) {
            $data['verificationCode'] = mt_rand(100000, 999999);
            event(new SendSmsEvent($data));
            $this->repository->create([
                'to' => $data['account'],
                'phone_number' => $data['account'],
                'verification_code' => $data['verificationCode'],
                'sent_time' => time(),
                'dtime' => time(),
            ]);
        } elseif ($verification['attributes']['sent_time'] + 1800 < time()) {
            $data['verificationCode'] = mt_rand(100000, 999999);
            event(new SendSmsEvent($data));
            $this->repository->update([
                'verification_code' => $data['verificationCode'],
                'sent_time' => time(),
            ], $verification['attributes']['id']);
        }
        return ['success' => true];
    }

    /**
     * @api            {post} /send/email 发送邮件
     * @apiVersion     0.1.0
     * @apiName        sendEmail
     * @apiDescription 发送邮件
     * @apiGroup       Other
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiParam {String}  email   邮箱[unique]
     * @apiParamExample {json} Request-Example:
     *     {
     *       "email": '412640511@qq.com'
     *     }
     * @apiSuccess {Boolean} success  是否成功
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         success: true
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "message": "发送失败"
     *       "errors": {
     *          "email": [
     *              "邮箱已注册，请登录。"
     *                      ]
     *                  },
     *       "status_code": 422,
     *     }
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *       "message": "发送失败，请稍后重试",
     *       "status_code": 500,
     *     }
     */
    public function email(EmailVerificationCodeCreateRequest $request)
    {
        $data = $request->only('email');

        $verification = $this->repository->findWhere(['to' => $data['email']])->first();

        if (empty($verification)) {
            $data['verificationCode'] = mt_rand(100000, 999999);
            event(new SendEmailEvent($data));
            $this->repository->create([
                'to' => $data['email'],
                'verification_code' => $data['verificationCode'],
                'sent_time' => time(),
                'dtime' => time(),
            ]);
        } elseif ($verification['attributes']['sent_time'] + 1800 < time()) {
            $data['verificationCode'] = mt_rand(100000, 999999);
            event(new SendEmailEvent($data));
            $this->repository->update([
                'verification_code' => $data['verificationCode'],
                'sent_time' => time(),
            ], $verification['attributes']['id']);
        }
        return ['success' => true];
    }


}