<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\DefaultIcon;

/**
 * Class DefaultIconTransformer
 * @package namespace App\Transformers;
 */
class DefaultIconTransformer extends TransformerAbstract
{

    /**
     * Transform the \DefaultIcon entity
     * @param \DefaultIcon $model
     *
     * @return array
     */
    public function transform(DefaultIcon $model)
    {
        return [
            'id'         => (int) $model->icon_id,
            'url'         => $model->icon_url.config('custom.img_reduce.img_separator').config('custom.img_reduce.user_logo'),
        ];
    }
}
