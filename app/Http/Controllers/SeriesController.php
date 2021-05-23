<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Series;
use App\Models\Episode;
use App\Http\Traits\StoreResourceTrait;

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
        $series = Series::orderByDesc('series.id')
            ->where('public', '=', '1')
            ->join('images', 'images.id', '=', 'series.thumbnail')
            ->select([
                'series.id as series_id',
                'series.title as series_title',
                'series.description as series_description',
                'images.name as image_name',
                'images.storage as image_storage'
            ])
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

        return view('series.index', [
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
        $validationArray = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'year' => 'required',
            'rating' => 'required|max:25',
            'cast' => 'required|max:500',
            'genre' => 'required|max:500',
            'thumbnail' => 'required|max:45',
            'public' => 'required|boolean',
        ];
        
        $validated = $request->validate($validationArray);

        $series = new Series();
        $series->title = $request->title;
        $series->description = $request->description;
        $series->year = $request->year;
        $series->rating = $request->rating;
        $series->cast = $request->cast;
        $series->genre = $request->genre;
        $series->thumbnail = $this->storeImage($request->thumbnail);
        $series->public = $request->public;
        
        $series->save();
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
        //Get the id of all the seasons from a specific series
        $seasons = Series::where([['series.id', '=', $id], ['series.public', '=', 1]])
            ->join('seasons', 'seasons.series_id', '=', 'series.id')->orderBy('seasons.order', 'asc')
            ->join('images', 'images.id', '=', 'seasons.thumbnail')
            ->get([
                'seasons.id as season_id', 
                'seasons.title', 
                'series.description as series_description',
                'series.title as series_title', 
                'series.id as series_id', 
                'images.name as image_name',
                'images.storage as image_storage'
            ]);            

        //All the episodes and seasons as separate array elements
        $series = [];

        for($i=0;$i<count($seasons);$i++)
        {
            $episode = Episode::where([['episodes.season_id', '=', $seasons[$i]->season_id], ['episodes.public', '=', 1]])
                ->orderBy('order', 'asc')
                ->get();
            
            $series[$i] = [
                'episode' => $episode,
                'season' => $seasons[$i]
            ];
        }

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

        //checks if the user is subscribed
        $user = Auth::user();

        return view('series.show', [
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
        $validationArray = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'year' => 'required',
            'rating' => 'required|max:25',
            'cast' => 'required|max:500',
            'genre' => 'required|max:500',
            'public' => 'required|boolean',
        ];

        $validated = $request->validate($validationArray);

        $series = Series::find($id);
        $series->title = $request->title;
        $series->description = $request->description;
        $series->year = $request->year;
        $series->rating = $request->rating;
        $series->cast = $request->cast;
        $series->genre = $request->genre;
        $series->public = $request->public;

        if($request->thumbnail != null)
        {
            $this->updateImageResource($request->thumbnail, $series->thumbnail, config('app.storage_disk'));
        }
        
        $series->save();

        return redirect()->route('seriesDashboard');
    }
}
