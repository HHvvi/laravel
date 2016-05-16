<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests;
use App\Repositories\MarkRepositoryEloquent as MarkRepository;


class MarksController extends BaseController
{
    protected $repository;


    public function __construct(MarkRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @api            {get} /default/mark 获取默认标签
     * @apiVersion     0.1.0
     * @apiName        getDefaultMark
     * @apiDescription 获取默认标签
     * @apiGroup       Other
     * @apiPermission  JWT
     * @apiUse         Validation
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *      [
     *          {
     *              "id": 1,
     *              "mark": "射手"
     *          },
     *          {
     *              "id": 2,
     *              "mark": "当家球星"
     *          },
     *                 .
     *                 .
     *                 .
     *      ]
     * @apiSuccess {Array[]} mark  默认标签列表.
     * @apiSuccess {Number} mark.id  标签ID.
     * @apiSuccess {String} mark.mark  标签名称.
     */
    public function index()
    { 
        $marks = $this->repository->all();
        return $marks['data'];
    }
}
