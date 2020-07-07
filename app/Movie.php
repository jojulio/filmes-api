<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'title', 
        'original_title', 
        'poster_path', 
        'imdb_id', 
        'original_language', 
        'overview', 
        'release_date',
        'runtime',
        'tmdb_id',
    ];

    public static function insertTitleGenres($titleGenres) 
    {
        DB::table('title_genres')->insert($titleGenres);
    }

    public function getGenresByMovie($id)
    {
        return DB::table('genres as g')
            ->select('g.*')
            ->leftJoin('title_genres as t', 't.genre_id', '=', 'g.id')
            ->where('t.movie_id', $id)
            ->get();
    }
}
