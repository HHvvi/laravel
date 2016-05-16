<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-25
 * Time: 上午10:17
 */

namespace App\Http\Controllers\Api\V1;


use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

class UploadController extends BaseController
{
    /**
     * @api            {get} /upload/token 获取七牛上传token
     * @apiVersion     0.1.0
     * @apiName        getQiNiuToken
     * @apiDescription 获取七牛上传token
     * @apiGroup       Other
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          {
     *              "qiniuToken": 'e1z-qHQxApgVMJb2ihBYOGLF2xwLVzcv2my9A1WB:1REeVPNpCj5Ospsf4rxVDKESNKc=:eyJzY29wZSI6InRlbXBvcmFyeS1zdG9yYWdlIiwiZGVhZGxpbmUiOjE0NjIzNTY2Mzd9',
     *          },
     *     }
     * @apiSuccess {String} qiniuToken  七牛token
     */
    public function token()
    {
        //TODO 分上传权限
        $accessKey = config('custom.qiniu.access_key');
        $secretKey = config('custom.qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('custom.qiniu.temporary_bucket');

        $qiniuToken = $auth->uploadToken($bucket);

        return compact('qiniuToken');
    }


    public function positiveImg($data)
    {
        $accessKey = config('custom.qiniu.access_key');
        $secretKey = config('custom.qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucketMgr = new BucketManager($auth);

        $temporaryBucket = config('custom.qiniu.temporary-storage');
        $fromKey = $data['key'];

        $bucket = config('custom.qiniu.open_bucket');
        $toKey = $data['module'] . '/' . time() . rand(10000, 99999) . '_api';

        $err = $bucketMgr->copy($temporaryBucket, $fromKey, $bucket, $toKey);

        if ($err !== null) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException('图片上传错误,请重新上传');
        }
        return $toKey;
    }
}