<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Content\IContentBuilder; 
use App\Helpers\Content\ValidationManager; 
use App\Helpers\Resource\ResourceHandler;
use App\Models\Movie;
use App\Helpers\Helper;

class MovieBuilder implements IContentBuilder
{
    /**
    * @var array names of the fields added by the user
    */
    protected $request;

    /**
     * Set the request
     *
     * @param Request $request 
     * 
     * @return ContentBuilder
     */
    public function setRequest(Request $request): IContentBuilder
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Validate the request data from the form
     * 
     * @return ContentBuilder
     */
    public function validate(): IContentBuilder
    {     
        $validationArray = ValidationManager::getValidationArray($this->request);
        $this->request->validate($validationArray);
        return $this;
    }

    /**
     * Store the movie
     * 
     * @return ContentBuilder
     */
    public function store(): IContentBuilder
    {
        $movie = new Movie();
        $movie->title = $this->request->title;
        $movie->description = $this->request->description;
        $movie->year = $this->request->year;
        $movie->rating = $this->request->rating;
        $seconds = Helper::timeToSeconds($this->request->length);
        $movie->length = $seconds;
        $movie->cast = $this->request->cast;
        $movie->genre = $this->request->genre;
        $movie->public = $this->request->public;
        $movie->premium = $this->request->availability;

        //If the content is not free it means that we must use auth
        if($movie->premium != 1)
            $movie->auth = $this->request->access;
        else
            $movie->auth = 1;

        //Update the video depending on the chosen platform
        if($this->request->video == null)
            $video = $this->request->videoId;
        else
            $video = $this->request->video;

        if($this->request->trailer == null)
            $trailer = $this->request->trailerId;
        else
            $trailer = $this->request->trailer; 

        //Link the thumbnail from images table to movies table
        $movie->thumbnail = ResourceHandler::addImage($this->request->thumbnail);
        $movie->video = ResourceHandler::addVideo($video, $this->request->platformVideo, $this->request->availability);
        $movie->trailer = ResourceHandler::addVideo($trailer, $this->request->platformTrailer, 0);

        $movie->save();

        return $this;
    }

    /**
     * Update the movie
     * 
     * @param int $id id of the movie to be updated
     * 
     * @return ContentBuilder
     */
    public function update($id): IContentBuilder
    {
        $movie = Movie::find($id);
        $movie->title = $this->request->title;
        $movie->description = $this->request->description;
        $movie->year = $this->request->year;
        $movie->rating = $this->request->rating;
        $seconds = Helper::timeToSeconds($this->request->length);
        $movie->length = $seconds;
        $movie->cast = $this->request->cast;
        $movie->genre = $this->request->genre;
        $movie->public = $this->request->public;
        $movie->premium = $this->request->availability;

        //dd($this->request->availability);

        //If the content is not free it means that we must use auth
        if($movie->premium != 1)
            $movie->auth = $this->request->access;
        else
            $movie->auth = 1;
        
        //Update thumbnail
        if($this->request->thumbnail != null)
            ResourceHandler::updateImage($this->request->thumbnail, $movie->thumbnail, config('app.storage_disk'));

        //Update video
        if($this->request->video != null)
            ResourceHandler::updateVideo($this->request->video, $movie->video, $this->request->platformVideo);

        if($this->request->videoId != null)
            ResourceHandler::updateVideo($this->request->videoId, $movie->video, $this->request->platformVideo);

        //Update trailer
        if($this->request->trailer != null)
            ResourceHandler::updateVideo($this->request->trailer, $movie->trailer, $this->request->platformTrailer, 0);

        if($this->request->trailerId != null)
            ResourceHandler::updateVideo($this->request->trailerId, $movie->trailer, $this->request->platformTrailer);

        $movie->save();

        return $this;
    }
}