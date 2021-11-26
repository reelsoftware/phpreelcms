<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Content\IContentBuilder; 
use App\Helpers\Content\ValidationManager; 
use App\Helpers\Resource\ResourceHandler;
use App\Models\Seasons;
use App\Helpers\Helper;

class SeasonBuilder implements IContentBuilder
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
     * Store the season
     * 
     * @return ContentBuilder
     */
    public function store(): IContentBuilder
    {
        $season = new Seasons();
        $season->title = $this->request->title;
        $season->description = $this->request->description;
        $season->series_id = $this->request->series_id;
        
        if($this->request->thumbnail != null)
        {
            $season->thumbnail = ResourceHandler::addImage($this->request->thumbnail);
        }

        if($this->request->trailer != null)
        {
            $trailer = $this->request->trailer;
            $season->trailer = ResourceHandler::addVideo($trailer, $this->request->platformTrailer, 0, 0);
        }
        else if($this->request->trailerId != null)
        {
            $trailer = $this->request->trailerId;
            $season->trailer = ResourceHandler::addVideo($trailer, $this->request->platformTrailer, 0, 0);
        }

        //Set the order of the season as the last season of the series
        $lastOrder = Seasons::where('series_id', '=', $this->request->series_id)
            ->orderBy('order', 'desc')
            ->first(['order']);

        if($lastOrder != null)
            $season->order = $lastOrder['order'] + 1;
        else 
            $season->order = 1;
        
        $season->save();

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
        $season = Seasons::find($id);
        $season->title = $this->request->title;
        $season->description = $this->request->description;
        $season->year = $this->request->year;
        
        //Update thumbnail
        if($this->request->thumbnail != null)
            ResourceHandler::updateImage($this->request->thumbnail, $season->thumbnail, config('app.storage_disk'));

        //Update trailer
        if($this->request->trailer != null)
            ResourceHandler::updateVideo($this->request->trailer, $season->trailer, $this->request->platformTrailer, 0, 0);

        if($this->request->trailerId != null)
            ResourceHandler::updateVideo($this->request->trailerId, $season->trailer, $this->request->platformTrailer);

        //If you update the season of a episode then set the order as the last episode of the season
        if($season->series_id != $this->request->series_id)
        {
            //Get the last value order for episodes
            $lastOrder = Seasons::where("series_id", "=", $this->request->series_id)
                            ->orderBy('order', 'DESC')
                            ->limit(1)
                            ->first('order');

            //Set it to 1 if there is not last order

            if($lastOrder != null)
                $season->order = $lastOrder['order'] + 1;
            else 
                $season->order = 1;
        }

        $season->series_id = $this->request->series_id;

        $season->save();

        return $this;
    }
}