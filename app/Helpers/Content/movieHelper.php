<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Helpers\Resource\ResourceHandler;

class MovieHelper
{
    /**
     * Validation for storing movies
     *
     * @param Illuminate\Http\Request $request
     * 
     */
    public static function validationArrayStore(Request $request)
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

        $request->validate($validationArray);
    }

    /**
     * Validation for storing movies
     *
     * @param Illuminate\Http\Request $request
     * 
     */
    public static function store(Request $request)
    {
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
        $movie->thumbnail = ResourceHandler::storeImage($request->thumbnail);

        //Store video to the database and file
        if($request->platformVideo == 'html5')
        {
            //Link the video from videos table to movies table
            $movie->video = ResourceHandler::addVideo($request->video);
        }
        else
            $movie->video = ResourceHandler::addVideoExternal($request->videoId, $request->platformVideo);

        //Store trailer to the database and file
        if($request->platformTrailer == 'html5')
        {
            //Link the video from videos table to movies table
            $movie->trailer = ResourceHandler::addVideo($request->trailer, 0);
        }
        else
        {
            $movie->trailer = ResourceHandler::addVideoExternal($request->trailerId, $request->platformTrailer);
        }

        $movie->save();
    }
}