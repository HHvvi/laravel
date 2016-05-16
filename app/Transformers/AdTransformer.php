<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Ad;

/**
 * Class AdTransformer
 * @package namespace App\Transformers;
 */
class AdTransformer extends TransformerAbstract
{

    /**
     * Transform the \Ad entity
     * @param \Ad $model
     *
     * @return array
     */
    public function transform(Ad $model)
    {
        return [
            'id' => (int)$model->ad_id,
            'name' => (string)$model->title,
            'content' => (string)$model->content,
            'link' => (string)$model->ad_link,
            'logo' => (string)$model->logo,
            'jump' => (string)$model->ad_jump,
        ];
    }
}
