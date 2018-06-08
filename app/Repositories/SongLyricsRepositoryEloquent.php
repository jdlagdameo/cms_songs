<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SongLyricsRepository;
use App\Entities\SongLyrics;
use App\Validators\SongLyricsValidator;

/**
 * Class SongLyricsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SongLyricsRepositoryEloquent extends BaseRepository implements SongLyricsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SongLyrics::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SongLyricsValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
