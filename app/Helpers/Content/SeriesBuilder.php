<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Content\IContentBuilder; 
use App\Helpers\Content\ValidationManager; 
use App\Helpers\Resource\ResourceHandler;
use App\Models\Series;
use App\Helpers\Helper;

class SeriesBuilder implements IContentBuilder
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
     * Store the series
     * 
     * @return ContentBuilder
     */
    public function store(): IContentBuilder
    {
        $series = new Series();
        $series->title = $this->request->title;
        $series->description = $this->request->description;
        $series->year = $this->request->year;
        $series->rating = $this->request->rating;
        $series->cast = $this->request->cast;
        $series->genre = $this->request->genre;
        $series->thumbnail = ResourceHandler::addImage($this->request->thumbnail);
        $series->public = $this->request->public;

        $series->save();

        return $this;
    }

    /**
     * Update the series
     * 
     * @param int $id id of the series to be updated
     * 
     * @return ContentBuilder
     */
    public function update($id): IContentBuilder
    {
        $series = Series::find($id);
        $series->title = $this->request->title;
        $series->description = $this->request->description;
        $series->year = $this->request->year;
        $series->rating = $this->request->rating;
        $series->cast = $this->request->cast;
        $series->genre = $this->request->genre;
        $series->public = $this->request->public;

        //Update thumbnail
        if($this->request->thumbnail != null)
            ResourceHandler::updateImage($this->request->thumbnail, $series->thumbnail, config('app.storage_disk'));
        
        $series->save();

        return $this;
    }
}