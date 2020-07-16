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

    public static function deleteTitleGenres($movie_id)
    {
        DB::table('title_genres')->where('movie_id', '=', $movie_id)->delete();
    }

    public function getGenresByMovie($id)
    {
        return DB::table('genres as g')
            ->select('g.*')
            ->leftJoin('title_genres as t', 't.genre_id', '=', 'g.id')
            ->where('t.movie_id', $id)
            ->get();
    }

    public function getMoviesByGenre($genreId)
    {
        return DB::table('movies as m')
            ->select('m.*')
            ->leftJoin('title_genres as t', 't.movie_id', '=', 'm.id')
            ->where('t.genre_id', $genreId)
            ->paginate(6);
    }
}
