<?php

namespace App\Presenters;

use App\Transformers\VerificationCodeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SmsVerificationCodePresenter
 *
 * @package namespace App\Presenters;
 */
class VerificationCodePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VerificationCodeTransformer();
    }
}
