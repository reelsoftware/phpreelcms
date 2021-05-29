<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\StoreResourceTrait;
use Auth;

class MovieController extends Controller
{
    use StoreResourceTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::orderByDesc('movies.id')
            ->where('public', '=', '1')
            ->join('images', 'images.id', '=', 'movies.thumbnail')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'movies.description as description',
                'movies.year as year',
                'movies.length as length',
                'movies.cast as cast',
                'movies.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->simplePaginate(9);

        $user = Auth::user();
        if($user != null)
        {
            $defaultSubscription = 'default';
            $subscribed = $user->subscribed($defaultSubscription);
        }
        else
        {
            $subscribed = false;
        }

        return view(env('THEME') . '.movie.index', [
            'content' => $movies, 
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
        return view('movie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationArray = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'year' => 'required',
            'rating' => 'required|max:25',
            'length' => 'required',
            'cast' => 'required|max:500',
            'genre' => 'required|max:500',
            'thumbnail' => 'required|max:45',
            'public' => 'required|boolean',
        ];
        
        //Platform for video 
        if($request->platformVideo == 'html5')
            $validationArray['video'] = 'required|max:45';
        else
            $validationArray['videoId'] = 'required|max:45';

        //Platform for trailer 
        if($request->platformTrailer == 'html5')
            $validationArray['trailer'] = 'required|max:45';
        else
            $validationArray['trailerId'] = 'required|max:45';

        $validated = $request->validate($validationArray);

        $seconds = $this->timeToSeconds($request->length);

        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->year = $request->year;
        $movie->rating = $request->rating;
        $movie->length = $seconds;
        $movie->cast = $request->cast;
        $movie->genre = $request->genre;
        $movie->public = $request->public;

        //Link the thumbnail from images table to movies table
        $movie->thumbnail = $this->storeImage($request->thumbnail);

        //Store video to the database and file
        if($request->platformVideo == 'html5')
        {
            //Link the video from videos table to movies table
            $movie->video = $this->storeVideo($request->video);
        }
        else
        {
            $movie->video = $this->storeVideoExternal($request->videoId, $request->platformVideo);
        }

        //Store trailer to the database and file
        if($request->platformTrailer == 'html5')
        {
            //Link the video from videos table to movies table
            $movie->trailer = $this->storeVideo($request->trailer, 0);
        }
        else
        {
            $movie->trailer = $this->storeVideoExternal($request->trailerId, $request->platformTrailer);
        }

        $movie->save();

        return redirect()->route('movieDashboard');
    }

    private function timeToSeconds(string $time): int
    {
        $d = explode(':', $time);
        return (intval($d[0]) * 3600) + (intval($d[1]) * 60);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::where([['movies.public', '=', '1'], ['movies.id', '=', $id]])
            ->join('videos', 'videos.id', '=', 'movies.video')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'movies.description as description',
                'movies.year as year',
                'movies.length as length',
                'movies.cast as cast',
                'movies.genre as genre',
                'movies.rating as rating',
                'videos.name as video_name',
                'videos.storage as video_storage',
            )
            ->first();

        $user = Auth::user();

        if($movie == null)
            return abort(404);

        $cast = explode(", ", $movie['cast']);
        $genre = explode(", ", $movie['genre']);

        return view(env('THEME') . '.movie.show', [
            'item' => $movie,
            'cast' => $cast, 
            'genre' => $genre
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
            ->select('title', 'description', 'year', 'length', 'cast', 'genre', 'rating', 'public', 'video', 'trailer', 'thumbnail')
            ->first();

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
        $validationArray = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'year' => 'required',
            'rating' => 'required|max:25',
            'length' => 'required',
            'cast' => 'required|max:500',
            'genre' => 'required|max:500',
            'public' => 'required|boolean',
        ];

        //Check for updated thumbnail
        if($request->thumbnail != null)
            $validationArray['thumbnail'] = 'required|max:45';

        //Check for updated video
        if($request->video != null)  
        {
            //Platform for video 
            if($request->platformVideo == 'html5')
                $validationArray['video'] = 'required|max:45';
            else
                $validationArray['videoId'] = 'required|max:45';
        }  
        
        //Check for updated trailer
        if($request->trailer != null)  
        {
            //Platform for trailer 
            if($request->platformTrailer == 'html5')
                $validationArray['trailer'] = 'required|max:45';
            else
                $validationArray['trailerId'] = 'required|max:45';
        }

        $validated = $request->validate($validationArray);
        $seconds = $this->timeToSeconds($request->length);

        $movie = Movie::find($id);
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->year = $request->year;
        $movie->rating = $request->rating;
        $movie->length = $seconds;
        $movie->cast = $request->cast;
        $movie->genre = $request->genre;
        $movie->public = $request->public;
        
        //Update thumbnail
        if($request->thumbnail != null)
        {
            $this->updateImageResource($request->thumbnail, $movie->thumbnail, config('app.storage_disk'));
        }


        //Update video
        if($request->platformVideo == 'html5')
        {
            if($request->video != null)
            {
                //Update the old video field with the new uploaded video
                $this->updateVideoResource($request->video, $movie->video, config('app.storage_disk'));
            } 
        }
        else if($request->platformVideo == 'youtube' || $request->platformVideo == 'vimeo')
        {
            if($request->videoId != null)
            {
                //Update the old video field with the new video id
                $this->updateVideoResource($request->videoId, $movie->video, $request->platformVideo);
            }
        }

        //Update trailer
        if($request->platformTrailer == 'html5')
        {
            if($request->trailer != null)
            {
                //Update the old trailer field with the new uploaded trailer
                $this->updateVideoResource($request->trailer, $movie->trailer, config('app.storage_disk'), 0);
            } 
        }
        else if($request->platformTrailer == 'youtube' || $request->platformTrailer == 'vimeo')
        {
            if($request->trailerId != null)
            {
                //Update the old trailer field with the new trailer id
                $this->updateVideoResource($request->trailerId, $movie->trailer, $request->platformTrailer);
            }
        }

        $movie->save();

        return redirect()->route('movieDashboard');
    }
}
