<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\VerificationCode;

/**
 * Class SmsVerificationCodeTransformer
 * @package namespace App\Transformers;
 */
class VerificationCodeTransformer extends TransformerAbstract
{

    /**
     * Transform the \SmsVerificationCode entity
     * @param \VerificationCode $model
     *
     * @return array
     */
    public function transform(VerificationCode $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
