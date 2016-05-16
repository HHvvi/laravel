<?php

namespace App\Presenters;

use App\Transformers\MarkTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MarkPresenter
 *
 * @package namespace App\Presenters;
 */
class MarkPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MarkTransformer();
    }
}
