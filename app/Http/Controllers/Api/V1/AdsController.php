<?php

namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\AdRepositoryEloquent;
use App\Validators\AdValidator;


class AdsController extends BaseController
{

    /**
     * @var AdRepository
     */
    protected $repository;

    /**
     * @var AdValidator
     */
    protected $validator;


    public function __construct(AdRepositoryEloquent $repository, AdValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * @api            {get} /ad?page=:page&search=:name 获取广告列表
     * @apiVersion     0.1.0
     * @apiName        getAdList
     * @apiDescription 获取广告列表
     * @apiGroup       Ad
     * @apiPermission  none
     * @apiUse         NotValidation
     * @apiParam {Number} page  页数
     * @apiParam {String} search  搜索词,标题和简介
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          {
     *              "id": 6,
     *              "name": "我是标题"
     *              "content": "黑龙江省大学生篮球联赛暨CUBA黑龙江赛区",
     *              "link": "http://mp.weixin.qq.com/s?__biz=MzA3NjYwOTE5MA==&mid=209322635&idx=1&sn=c6a428247e01f88bd6acb38343177db4#rd"
     *              "logo": "http://league.tykapp.com/img/league/2015/201505151048221346.jpg"
     *              "jump": "activity_detail"
     *          },
     *     }
     * @apiSuccess {Number} id   广告ID.
     * @apiSuccess {String} name   广告标题.
     * @apiSuccess {String} content   广告简介.
     * @apiSuccess {Number} link   广告跳转链接.
     * @apiSuccess {Url} logo   广告图片.
     * @apiSuccess {String} jump   广告跳转页面.
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $data = $this->repository->paginate();
        return $data['data'];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('ads.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  AdCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $ad = $this->repository->create($request->all());

            $response = [
                'message' => 'Ad created.',
                'data'    => $ad->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $ad = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $ad,
            ]);
        }

        return view('ads.show', compact('ad'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $ad = $this->repository->find($id);

        return view('ads.edit', compact('ad'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AdUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(AdUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $ad = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Ad updated.',
                'data'    => $ad->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Ad deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Ad deleted.');
    }
}
