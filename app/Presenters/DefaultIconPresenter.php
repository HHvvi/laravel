<?php

namespace App\Presenters;

use App\Transformers\DefaultIconTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DefaultIconPresenter
 *
 * @package namespace App\Presenters;
 */
class DefaultIconPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DefaultIconTransformer();
    }
}
