<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-5-3
 * Time: 上午9:02
 */

namespace App\Http\Controllers\Api\V1;

use App\Repositories\DefaultIconRepositoryEloquent as DefaultIconRepository;
use App\Repositories\MarkRepositoryEloquent as MarkRepository;

class OtherController extends BaseController
{
    /**
     * @api            {get} /default/logo 获取默认头像
     * @apiVersion     0.1.0
     * @apiName        getDefaultLogo
     * @apiDescription 获取默认头像
     * @apiGroup       Other
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *      [
     *          {
     *              "id": 0,
     *              "url": "http://img.dev.tykapp.com/201507271445553667073481"
     *          }
     *                 .
     *                 .
     *                 .
     *      ]
     * @apiSuccess {Array[]} logo  默认头像列表.
     * @apiSuccess {Number} logo.id  默认头像ID.
     * @apiSuccess {String} logo.url  默认头像URL.
     */
    public function defaultLogo(DefaultIconRepository $repository)
    {
        $logo = $repository->all();
        return $logo['data'];
    }
    
}