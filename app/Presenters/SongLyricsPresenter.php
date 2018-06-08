<?php

namespace App\Presenters;

use App\Transformers\SongLyricsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SongLyricsPresenter.
 *
 * @package namespace App\Presenters;
 */
class SongLyricsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SongLyricsTransformer();
    }
}
