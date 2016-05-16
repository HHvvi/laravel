<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-19
 * Time: 下午3:25
 */

namespace App\Http\Controllers\Api\V1;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class TestController extends BaseController
{
    public function index(){
        $accessKey = config('custom.qiniu.access_key');
        $secretKey = config('custom.qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('custom.qiniu.temporary_bucket');

        $token = $auth->uploadToken($bucket);

        return compact('token');
    }
}