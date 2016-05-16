<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\UserMark;

/**
 * Class UserMarkTransformer
 * @package namespace App\Transformers;
 */
class UserMarkTransformer extends TransformerAbstract
{

    /**
     * Transform the \UserMark entity
     * @param \UserMark $model
     *
     * @return array
     */
    public function transform(UserMark $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
