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
        $movies = DB::table('movies')->paginate(6);

        foreach ($movies->items() as $key => $value) {
            $movies[$key]->genres = $movie->getGenresByMovie($value->id);
        }

        $response = [
            'pagination' => [
                'total' => $movies->total(),
                'per_page' => $movies->perPage(),
                'current_page' => $movies->currentPage(),
                'last_page' => $movies->lastPage(),
                'from' => $movies->firstItem(),
                'to' => $movies->lastItem()
            ],
            'data' => $movies
        ];
       
        return ['status'=> true, 'movies'=> $response]; 
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
            return ['status'=> false, 'validation'=> true, 'erros'=> $validation->errors()];
        }

        DB::beginTransaction();

        $movie = Movie::create($data);

        $this->addTitleGenres($movie, $data['genres']);

        DB::commit();

        return ['status'=> true, 'movie_id'=> $movie->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = new Movie();
        $movie = $model->find($id);

        $movie['genres'] = $model->getGenresByMovie($id);

        return $movie;
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
            return ['status'=> false, 'validation' => true, 'erros' => $validation->errors()];
        }

        DB::beginTransaction();
        $movie = Movie::find($id);
        unset($data['id']);

        $movie->update($data);

        $this->removeTitleGenres($id);
        $this->addTitleGenres($movie, $data['genres']);

        DB::commit();

        return ['status'=> true, 'movie_id'=> $id];
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

    public function removeTitleGenres($movie_id)
    {
        $movie = new Movie();
        $movie::deleteTitleGenres($movie_id);        
    }
}
