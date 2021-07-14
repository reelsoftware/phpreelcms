<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\Seasons;
use App\Models\Video;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Content\SeasonBuilder; 

class SeasonController extends Controller
{
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
        $builder = new SeasonBuilder();

        $builder->setRequest($request)->validate()->store();

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
        $builder = new SeasonBuilder();

        $builder->setRequest($request)->validate()->update($id);

        return redirect()->route('seasonDashboard');
    }
}
