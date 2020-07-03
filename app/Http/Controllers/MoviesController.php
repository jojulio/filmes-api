<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;
use Validator;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
         ]);

        if ($validation->fails()) {
            return ['status'=> false, 'validation'=> true, 'erros'=>$validation->errors()];
        }

        $movie = Movie::create($data);
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
}
