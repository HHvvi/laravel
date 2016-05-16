<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Activity;

/**
 * Class ActivityTransformer
 * @package namespace App\Transformers;
 */
class ActivityTransformer extends TransformerAbstract
{

    /**
     * Transform the Activity entity
     * @param Activity $model
     *
     * @return array
     */
    public function transform(Activity $model)
    {
        return [
            'aid' => (int)$model->activity_id,
            'name' => (string)$model->activity_title,
            'type' => (int)$model->activity_type,
            'matchType' => (int)$model->activity_match_type,
            'isOffical' => (int)$model->activity_offical,
            'isRecommended' => (int)$model->is_recommended,
            'uid' => (string)$model->user_guid,
            'sportId' => (int)$model->sport_id,
            'address' => (string)$model->activity_address,
            'content' => (string)$model->activity_content,
            'logo' => (string)$model->activity_logo
        ];
    }
}
