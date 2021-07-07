<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Series;
use App\Models\Episode;
use App\Http\Traits\StoreResourceTrait;
use App\Helpers\Content\ContentHandler;
use App\Helpers\User\UserHandler;
use App\Helpers\Theme\Theme;
use App\Helpers\Content\SeriesBuilder; 

class SeriesController extends Controller
{
    use StoreResourceTrait;

    public function indexDashboard()
    {
        $series = Series::orderByDesc('id')->simplePaginate(10);

        return view('series.indexDashboard', [
            'series' => $series, 
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $series = ContentHandler::getLatestSeriesSimplePaginate(9);

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('series.index', [
            'series' => $series, 
            'subscribed' => $subscribed,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $builder = new SeriesBuilder();

        $builder->setRequest($request)->validate()->store();
        return redirect()->route('seriesDashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $series = ContentHandler::getSeries($id);

        if($series == null)
            return view('series.show', [
                'content' => null,
                'seriesLength' => null,
                'seasonsLength' => null
            ]);

        //Calculate length of the whole series and of each season
        $seriesLength = 0;
        $seasonsLength = [];

        //Set the current season id
        $currentSeasonId = $series[0]['season']->season_id;

        //Temp variable to calculate the length of the season
        $currentSeasonLength = 0;
        foreach($series as $content) 
        {
            foreach($content['episode'] as $episode)
            {
                $seriesLength += $episode['length'];

                //Check if the current season is the same with the current iterating season
                if($currentSeasonId == $content['season']['season_id'])
                    $currentSeasonLength += $episode['length'];
                else
                {
                    //Add the season length to the array
                    $seasonsLength[$currentSeasonId] = $currentSeasonLength;

                    //Set the new $currentSeasonId
                    $currentSeasonId = $content['season']['season_id'];

                    //Set the $currentSeasonLength to the length of the first episode of the new season
                    $currentSeasonLength = $episode['length'];
                }
            }

            //If there are no episodes then just add 0 to season length
            if(count($content['episode']) == 0)
            {
                //Add the season length to the array
                $seasonsLength[$currentSeasonId] = 0;

                //Set the new $currentSeasonId
                $currentSeasonId = $content['season']['season_id'];
            }

        }

        //Add the last season length to the array
        $seasonsLength[$currentSeasonId] = $currentSeasonLength;
                
        if($series == null || isset($series[0]) == false)
            return abort(404);

        return Theme::view('series.show', [
            'content' => $series,
            'seriesLength' => $seriesLength,
            'seasonsLength' => $seasonsLength
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
        $series = Series::find($id);
       
        if($series != null)
            $content = $series;
        else
            dd('Wrong id');

        return view('series.edit', [
            'content' => $content,
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
        $builder = new SeriesBuilder();

        $builder->setRequest($request)->validate()->update($id);

        return redirect()->route('seriesDashboard');
    }
}
