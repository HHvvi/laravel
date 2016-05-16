<?php

namespace App\Presenters;

use App\Transformers\UserMarkTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserMarkPresenter
 *
 * @package namespace App\Presenters;
 */
class UserMarkPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserMarkTransformer();
    }
}
