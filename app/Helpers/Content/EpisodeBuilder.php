<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Content\IContentBuilder; 
use App\Helpers\Content\ValidationManager; 
use App\Helpers\Resource\ResourceHandler;
use App\Models\Episode;
use App\Helpers\Helper;

class EpisodeBuilder implements IContentBuilder
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
     * Store the episode
     * 
     * @return ContentBuilder
     */
    public function store(): IContentBuilder
    {
        $episode = new Episode();
        $episode->title = $this->request->title;
        $episode->description = $this->request->description;
        $seconds = Helper::timeToSeconds($this->request->length);
        $episode->length = $seconds;
        $episode->public = $this->request->public;
        $episode->premium = $this->request->availability;

        //If the content is not free it means that we must use auth
        if($episode->premium != 1)
            $episode->auth = $this->request->access;
        else
            $episode->auth = 1;

        if($this->request->video != null)
            $video = $this->request->video;
        else if($this->request->videoId != null)
            $video = $this->request->videoId;

        $episode->season_id = $this->request->season_id;
        $episode->thumbnail = ResourceHandler::addImage($this->request->thumbnail);
        $episode->video = ResourceHandler::addVideo($video, $this->request->platformVideo, $episode->premium, $episode->auth);

        //Set the order of the season as the last season of the series
        $lastOrder = Episode::where('season_id', '=', $this->request->season_id)
            ->orderBy('order', 'desc')
            ->first(['order']);

        if($lastOrder != null)
            $episode->order = $lastOrder['order'] + 1;
        else
            $episode->order = 1;

        $episode->save();

        return $this;
    }

    /**
     * Update the episode
     * 
     * @param int $id id of the episode to be updated
     * 
     * @return ContentBuilder
     */
    public function update($id): IContentBuilder
    {
        $episode = Episode::find($id);
        $episode->title = $this->request->title;
        $episode->description = $this->request->description;
        $seconds = Helper::timeToSeconds($this->request->length);
        $episode->length = $seconds;
        $episode->public = $this->request->public;
        $episode->premium = $this->request->availability;

        //If the content is not free it means that we must use auth
        if($episode->premium != 1)
            $episode->auth = $this->request->access;
        else
            $episode->auth = 1;
        
        //If you update the season of a episode then set the order as the last episode of the season
        if($episode->season_id != $this->request->season_id)
        {
            //Get the last value order for episodes
            $lastOrder = Episode::where("season_id", "=", $this->request->season_id)
                            ->orderBy('order', 'DESC')
                            ->limit(1)
                            ->first('order');

            //Set it to 1 if there is not last order
            if($lastOrder == null)
                $episode->order = 1;
            else
                $episode->order = $lastOrder->order + 1;
        }

        $episode->season_id = $this->request->season_id;
        
        //Update thumbnail
        if($this->request->thumbnail != null)
            ResourceHandler::updateImage($this->request->thumbnail, $episode->thumbnail, config('app.storage_disk'));

        //Update video
        if($this->request->video != null)
            ResourceHandler::updateVideo($this->request->video, $episode->video, $this->request->platformVideo, $episode->premium, $episode->auth);

        if($this->request->videoId != null)
            ResourceHandler::updateVideo($this->request->videoId, $episode->video, $this->request->platformVideo);

        $episode->save();
        
        return $this;
    }
}