<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\Seasons;
use App\Models\Video;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\StoreResourceTrait;

class SeasonController extends Controller
{
    use StoreResourceTrait;

    public function seasonsOrderEdit($id)
    {
        $seasons = Seasons::where('series_id', '=', $id)
            ->orderBy('seasons.order', 'asc')
            ->select([
                'id', 
                'title', 
                'order', 
            ])
            ->get();

        return view('season.order', [
            'seasons' => $seasons,
            'id' => $id
        ]);
    }

    public function seasonsOrderUpdate(Request $request, $id)
    {
        //Iterate throughout the order list and add validation rules to all of them

        //Add the first item to the array
        $orderItem = 0;

        $validationArray = [];

        //Add validation rules
        for($i=0;$i<$request->countSeasons;$i++)
        {
            $validationArray['order' . $i] = 'required|string';
            $validationArray['season' . $i] = 'required|numeric';
        }

        $validated = $request->validate($validationArray);

        //Add seasons id to seasons array
        $seasonsIds = [];

        for($i=0;$i<$request->countSeasons;$i++)
        {
            array_push($seasonsIds, $request['season' . $i]);
        }

        //Get all the seasons that are being modified
        $seasons = Seasons::whereIn('id', $seasonsIds)->orderBy('order', 'ASC')->get();

        //Update order and save to the database
        foreach($seasons as $key => $season)
        {
            $season->order = $request['order' . $key];
            $season->save();
        }
       
        return redirect()->route('seriesDashboard');
    }

    public function indexDashboard()
    {
        $seasons = Seasons::orderByDesc('id')
            ->join('series', 'series.id', '=', 'seasons.series_id')
            ->select([
                'seasons.id', 
                'seasons.title', 
                'seasons.created_at', 
                'series.title as series_title'
            ])
            ->simplePaginate(10);
            
        return view('season.indexDashboard', [
            'seasons' => $seasons, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $series = Series::orderBy('id', 'desc')
            ->get(['id', 'title']);

        return view('season.create', [
            'series' => $series,
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
        $validationArray = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'year' => 'required',
            'thumbnail' => 'required|max:45',
            'series_id' => 'required|numeric'
        ];

        $validated = $request->validate($validationArray);

        $season = new Seasons();
        $season->title = $request->title;
        $season->description = $request->description;
        $season->year = $request->year;
        $season->series_id = $request->series_id;

        //Link the thumbnail from images table to movies table
        $season->thumbnail = $this->storeImage($request->thumbnail);

        //Store trailer to the database and file
        if($request->platformTrailer == 'html5')
        {
            //Link the video from videos table to movies table
            $season->trailer = $this->storeVideo($request->trailer, 0);
        }
        else
        {
            $season->trailer = $this->storeVideoExternal($request->trailerId, $request->platformTrailer);
        }

        //Set the order of the season as the last season of the series
        $lastOrder = Seasons::where('series_id', '=', $request->series_id)
            ->orderBy('order', 'desc')
            ->first(['order']);

        if($lastOrder != null)
            $season->order = $lastOrder['order'] + 1;
        else 
            $season->order = 1;
        
        $season->save();

        return redirect()->route('seasonDashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $season = Seasons::find($id);
       
        if($season != null)
            $content = $season;
        else
            abort(404);

        $trailer = Video::where('id', '=', $season['trailer'])->first(['name', 'storage']);

        $series = Series::orderBy('id', 'desc')
            ->get(['id', 'title']);

        return view('season.edit', [
            'content' => $content,
            'id' => $id,
            'series' => $series,
            'trailer' => $trailer
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
            'series_id' => 'required|numeric'
        ];

        //Check for updated thumbnail
        if($request->thumbnail != null)
            $validationArray['thumbnail'] = 'required|max:45';

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

        $season = Seasons::find($id);
        $season->title = $request->title;
        $season->description = $request->description;
        $season->year = $request->year;
        
        //Update thumbnail
        if($request->thumbnail != null)
        {
            $this->updateImageResource($request->thumbnail, $season->thumbnail, config('app.storage_disk'));
        }

        //Update trailer
        if($request->platformTrailer == 'html5')
        {
            if($request->trailer != null)
            {
                //Update the old trailer field with the new uploaded trailer
                $this->updateVideoResource($request->trailer, $season->trailer, config('app.storage_disk'), 0);
            } 
        }
        else if($request->platformTrailer == 'youtube' || $request->platformTrailer == 'vimeo')
        {
            if($request->trailerId != null)
            {
                //Update the old trailer field with the new trailer id
                $this->updateVideoResource($request->trailerId, $season->trailer, $request->platformTrailer);
            }
        }

        //If you update the season of a episode then set the order as the last episode of the season
        if($season->series_id != $request->series_id)
        {
            //Get the last value order for episodes
            $lastOrder = Seasons::where("series_id", "=", $request->series_id)
                            ->orderBy('order', 'DESC')
                            ->limit(1)
                            ->first('order');

            //Set it to 1 if there is not last order
            if($lastOrder == null)
                $season->order = 1;
            else
                $season->order = $lastOrder->order + 1;
        }

        $season->series_id = $request->series_id;

        $season->save();

        return redirect()->route('seasonDashboard');
    }
}
