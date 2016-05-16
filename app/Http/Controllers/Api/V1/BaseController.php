<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-11
 * Time: 下午5:31
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use JWTAuth;
class BaseController extends Controller
{
    public function Uid(){
        return JWTAuth::getPayload()['sub'];
    }

}