<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-12
 * Time: 下午3:13
 */

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ActivityCriteria implements CriteriaInterface
{

    /**
     * Apply criteria in query repository
     *
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('activity_status','<', '50' );
        return $model;
    }
}