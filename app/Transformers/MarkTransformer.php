<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Mark;

/**
 * Class MarkTransformer
 * @package namespace App\Transformers;
 */
class MarkTransformer extends TransformerAbstract
{

    /**
     * Transform the \Mark entity
     * @param \Mark $model
     *
     * @return array
     */
    public function transform(Mark $model)
    {
        return [
            'id'         => (int) $model->mark_id,
            'mark'         => $model->mark_content,
        ];
    }
}
