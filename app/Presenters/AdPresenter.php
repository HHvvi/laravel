<?php

namespace App\Presenters;

use App\Transformers\AdTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AdPresenter
 *
 * @package namespace App\Presenters;
 */
class AdPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AdTransformer();
    }
}
