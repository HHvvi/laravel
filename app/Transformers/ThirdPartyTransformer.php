<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ThirdParty;

/**
 * Class ThirdPartyTransformer
 * @package namespace App\Transformers;
 */
class ThirdPartyTransformer extends TransformerAbstract
{

    /**
     * Transform the \ThirdParty entity
     * @param \ThirdParty $model
     *
     * @return array
     */
    public function transform(ThirdParty $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
