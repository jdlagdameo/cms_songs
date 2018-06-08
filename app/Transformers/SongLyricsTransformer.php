<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\SongLyrics;

/**
 * Class SongLyricsTransformer.
 *
 * @package namespace App\Transformers;
 */
class SongLyricsTransformer extends TransformerAbstract
{
    /**
     * Transform the SongLyrics entity.
     *
     * @param \App\Entities\SongLyrics $model
     *
     * @return array
     */
    public function transform(SongLyrics $model)
    {
        $actions = '<div class="btn-group">
                          <button title="Edit" class="btn btn-info" data-toggle="modal" data-value="'.$model->id    .'" data-target="#modal-form" onclick="openModal(this)"><i class="fa fa-edit"></i></button>
                          <button title="Delete" class="btn btn-danger btn-delete" onclick="deleteItem(this)" data-value="'.$model->id    .'"><i class="fa fa-trash"></i></button>
                          <button title="View Lyrics" class="btn btn-default btn-block" data-toggle="modal" data-value="'.$model->id    .'" data-target="#modal-lyrics" onclick="openLyricsModal(this)"><i class="fa fa-music"></i></button>
                    </div>
                    ';
        return [
            'id'         => (int) $model->id,
            'title' => $model->title,
            'artist' => $model->artist,
            'lyrics' => $model->lyrics,
            /* place your other model properties here */
            'logs' => "Date Created:<br/>".date("M d, Y h:i:s A",strtotime($model->created_at))."<br><br>
                       Date Updated:<br/>".date("M d, Y h:i:s A",strtotime($model->updated_at)),
            'actions' => $actions
        ];
    }
}
