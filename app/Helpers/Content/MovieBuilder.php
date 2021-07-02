<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ContentManager implements ContentBuilder
{
    /**
    * @var array names of the fields added by the user
    */
    protected $request;

    public function setRequest($request): ContentBuilder
    {
        $this->request = $request;
    }

    public function validate(): ContentBuilder
    {
        $movie = new Movie();
        $movie->title = $this->request->title;
        $movie->description = $this->request->description;
        $movie->year = $this->request->year;
        $movie->rating = $this->request->rating;
        $seconds = $this->timeToSeconds($this->request->length);
        $movie->length = $seconds;
        $movie->cast = $this->request->cast;
        $movie->genre = $this->request->genre;
        $movie->public = $this->request->public;

        //Link the thumbnail from images table to movies table
        $movie->thumbnail = ResourceHandler::storeImage($this->request->thumbnail);
        $movie->video = ResourceHandler::addVideo($this->request->video, $this->request->platformVideo);
        $movie->trailer = ResourceHandler::addVideo($this->request->trailer, $this->request->platformTrailer, 0);

        $movie->save();

        return $this;
    }
}