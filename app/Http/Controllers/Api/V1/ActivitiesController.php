<?php

namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\ActivityRepositoryEloquent;
use App\Validators\ActivityValidator;


class ActivitiesController extends BaseController
{
    protected $repository;
    protected $validator;


    public function __construct(ActivityRepositoryEloquent $repository, ActivityValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @api            {get} /activity?page=:page&search=:name 获取活动列表
     * @apiVersion     0.1.0
     * @apiName        getActivityList
     * @apiDescription 获取活动列表
     * @apiGroup       Activity
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiParam {Number} page  页数
     * @apiParam {String} search  搜索词
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          {
     *              "aid": 6,
     *              "name": "我是标题"
     *              "type": 2,
     *              "matchType": 1,
     *              "isOffical": 2,
     *              "isRecommended": 0,
     *              "uid": "2da571a0f6bbf9744d277e721a016337",
     *              "sportId": 7,
     *              "address": "惠州",
     *              "content": "金钥匙义工协会2015年首届社区“和谐杯”男子篮球邀请赛",
     *              "logo": "http://league.tykapp.com/img/league/2015/201505151048221346.jpg"
     *          },
     *     }
     * @apiSuccess {Number} aid   活动ID.
     * @apiSuccess {String} name   活动标题.
     * @apiSuccess {Url} logo   活动LOGO.
     * @apiSuccess {Number} type   活动类型.
     * @apiSuccess {Number} matchType   赛程类型.
     * @apiSuccess {Number} isOffical   是否为官方.
     * @apiSuccess {Number} isRecommended   是否为推荐.
     * @apiSuccess {String} uid   活动创建人guid.
     * @apiSuccess {Number} sportId   运动类型.
     * @apiSuccess {String} address   活动地点.
     * @apiSuccess {String} content   活动简介.
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $data = $this->repository->paginate();

        return $data['data'];
    }

    /**
     * @api            {get} /activity/:id 获取活动详情
     * @apiVersion     0.1.0
     * @apiName        getActivity
     * @apiDescription 获取活动详情
     * @apiGroup       Activity
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "aid": 6,
     *          "name": "我是标题"
     *          "type": 2,
     *          "matchType": 1,
     *          "isOffical": 2,
     *          "isRecommended": 0,
     *          "uid": "2da571a0f6bbf9744d277e721a016337",
     *          "sportId": 7,
     *          "address": "惠州",
     *          "content": "金钥匙义工协会2015年首届社区“和谐杯”男子篮球邀请赛",
     *          "logo": "http://league.tykapp.com/img/league/2015/201505151048221346.jpg"
     *     }
     * @apiSuccess {Number} aid   活动ID.
     * @apiSuccess {String} name   活动标题.
     * @apiSuccess {Url} logo   活动LOGO.
     * @apiSuccess {Number} type   活动类型.
     * @apiSuccess {Number} matchType   赛程类型.
     * @apiSuccess {Number} isOffical   是否为官方.
     * @apiSuccess {Number} isRecommended   是否为推荐.
     * @apiSuccess {String} uid   活动创建人guid.
     * @apiSuccess {Number} sportId   运动类型.
     * @apiSuccess {String} address   活动地点.
     * @apiSuccess {String} content   活动简介.
     * @apiError       ActivityNotFound 活动不存在.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "message": "活动不存在或已经解散"
     *       "status_code": 404
     *     }
     */
    public function show($id)
    {
        try {
            $activity = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('活动不存在');
        }

        return $activity['data'];
    }

    /**
     *
     * @api            {post} /activity 创建活动
     * @apiVersion     0.1.0
     * @apiName        createActivity
     * @apiDescription 创建活动
     * @apiGroup       Activity
     * @apiPermission  jwt
     * @apiUse         Validation
     * @apiParam {String} name  活动标题
     * @apiParam {Url} logo  活动LOGO
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": 我是活动名称
     *       "logo": http://fdssdf.com/hkjdsf.jpg
     *     }
     * @apiSuccess {String} name   活动标题.
     * @apiSuccess {Url} logo   活动LOGO.
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "aid": 6,
     *          "name": "我是标题"
     *          "type": 2,
     *          "matchType": 1,
     *          "isOffical": 2,
     *          "isRecommended": 0,
     *          "uid": "2da571a0f6bbf9744d277e721a016337",
     *          "sportId": 7,
     *          "address": "惠州",
     *          "content": "金钥匙义工协会2015年首届社区“和谐杯”男子篮球邀请赛",
     *          "logo": "http://league.tykapp.com/img/league/2015/201505151048221346.jpg"
     *     }
     * @apiError       StoreResourceFailed 请填写完整的资料.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Unprocessable Entity
     *     {
     *       "message": "请填写完整的资料.",
     *       "errors": {
     *          "name": [
     *              "赛事名称不能为空。"
     *                  ],
     *          "logo": [
     *              "赛事宣传图不能为空。"
     *                  ]
     *                 },
     *       "status_code": 422,
     *     }
     */
    public function store(Request $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

//            $activity = $this->repository->create($request->all());

            return $request->all();
        } catch (ValidatorException $e) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('请填写完整的资料.', $e->getMessageBag());
        }
    }

    /**
     *
     * @api            {put} /activity/:id 修改活动
     * @apiVersion     0.1.0
     * @apiName        updateActivity
     * @apiDescription 修改活动
     * @apiGroup       Activity
     * @apiPermission  jwt
     * @apiParam {String} name  活动标题
     * @apiParam {Url} logo  活动LOGO
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": 我是活动名称
     *       "logo": http://fdssdf.com/hkjdsf.jpg
     *     }
     * @apiError       StoreResourceFailed 请填写完整的资料.
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Unprocessable Entity
     *     {
     *       "message": "请填写完整的资料.",
     *       "errors": {
     *          "name": [
     *              "赛事名称不能为空。"
     *                  ],
     *          "logo": [
     *              "赛事宣传图不能为空。"
     *                  ]
     *                 },
     *       "status_code": 422,
     *     }
     *
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
//            $activity = $this->repository->update($request->all(), $id);
            return $request->all();
        } catch (ValidatorException $e) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('请填写完整的资料.', $e->getMessageBag());
        }
    }

    /**
     * @api            {delete} /activity/:id 删除活动
     * @apiVersion     0.1.0
     * @apiName        destroyActivity
     * @apiDescription 删除活动
     * @apiGroup       Activity
     * @apiPermission  jwt
     * @apiParamExample {json} Request-Example:
     *     {
     *       "message":
     *     }
     */
    public function destroy($id)
    {
//        $deleted = $this->repository->delete($id);

        return ['id' => $id];
    }
}