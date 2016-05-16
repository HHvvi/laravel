<?php

namespace App\Presenters;

use App\Transformers\ThirdPartyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ThirdPartyPresenter
 *
 * @package namespace App\Presenters;
 */
class ThirdPartyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ThirdPartyTransformer();
    }
}
