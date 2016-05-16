<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

/**
 * Class UserTransformer
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => $model->user_guid,
            'name'         => $model->nick_name,
            'sex'         => $model->sex,
            'bornDate'         => $model->born_date,
            'height'         => $model->height,
            'weight'         => $model->weight,
        ];
    }
}
