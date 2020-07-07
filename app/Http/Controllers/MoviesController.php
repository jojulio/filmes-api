<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movie = new Movie();
        $movies = $movie->get();

        foreach ($movies as $key => $value) {
            $movies[$key]['genres'] = $movie->getGenresByMovie($value['id']);
        }
        
        return ['status'=> true, 'movies'=> $movies];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validation = Validator::make($data, [
            'title' => 'required', 
            'original_title' => 'required',
            'poster_path' => 'required',
            'imdb_id' => 'required',
            'original_language' => 'required',
            'overview' => 'required',
            'release_date' => 'required',
            'runtime' => 'required',
            'tmdb_id' => 'required',
            'genres' => 'required'
         ]);

        if ($validation->fails()) {
            return ['status'=> false, 'validation'=> true, 'erros'=>$validation->errors()];
        }

        DB::beginTransaction();

        $movie = Movie::create($data);

        $this->addTitleGenres($movie, $data['genres']);

        DB::commit();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addTitleGenres($movie, $genres)
    {
        if ($genres) {
            $titleGenres = array();
            
            foreach ($genres as $genre) {
                $titleGenre = array(
                    'movie_id' => $movie->id,
                    'genre_id' => $genre['id']
                );

                array_push($titleGenres, $titleGenre);
            }

            Movie::insertTitleGenres($titleGenres);
        }

    }
}
