<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
