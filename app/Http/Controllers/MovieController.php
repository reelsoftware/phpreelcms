<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Content\ContentHandler; 
use App\Models\Movie;
use App\Helpers\Content\MovieBuilder; 
use App\Helpers\User\UserHandler;
use App\Helpers\Theme\Theme;
use App\Models\Category;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = ContentHandler::getLatestMoviesSimplePaginate(9);

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('movie.index', [
            'content' => $content, 
            'subscribed' => $subscribed,
        ]);
    }

    /**
     * Display a listing of the resource in the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDashboard()
    {
        $movies = Movie::orderByDesc('id')->simplePaginate(10);

        return view('movie.indexDashboard', [
            'movies' => $movies, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('movie.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $builder = new MovieBuilder();

        $builder->setRequest($request)->validate()->store();
        return redirect()->route('movieDashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = ContentHandler::getMovie($id);

        if($movie == null)
            return abort(404);

        $categories = json_decode($movie->categories, true);
        
        return Theme::view('movie.show', [
            'item' => $movie,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movie = Movie::where('id', '=', $id)
            ->select([
                'title', 
                'description', 
                'year', 
                'length', 
                'cast', 
                'genre', 
                'rating', 
                'public', 
                'video', 
                'trailer', 
                'thumbnail', 
                'premium', 
                'auth'
            ])->first();

        if($movie != null)
            $content = $movie;
        else
            abort(404);    

        $video = Video::where('id', '=', $movie['video'])->first(['name', 'storage']);
        $trailer = Video::where('id', '=', $movie['trailer'])->first(['name', 'storage']);

        return view('movie.edit', [
            'content' => $content,
            'video' => $video,
            'trailer' => $trailer,
            'id' => $id,
        ]);
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
        $builder = new MovieBuilder();

        $builder->setRequest($request)->validate()->update($id);

        return redirect()->route('movieDashboard');
    }
}
