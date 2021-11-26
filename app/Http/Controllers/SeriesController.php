<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Video;
use App\Models\Category;
use App\Helpers\Content\ContentHandler;
use App\Helpers\User\UserHandler;
use App\Helpers\Theme\Theme;
use App\Helpers\Content\SeriesBuilder; 

class SeriesController extends Controller
{
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
            'content' => $series, 
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
        $categories = Category::all();

        return view('series.create', [
            'categories' => $categories
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
            return Theme::view('series.show', [
                'content' => null,
                'seriesLength' => null,
                'seasonsLength' => null
            ]);

        $length = ContentHandler::getSeriesSeasonsLength($series);
                
        if($series == null || isset($series[0]) == false)
            return abort(404);
     
        return Theme::view('series.show', [
            'content' => $series,
            'seriesLength' => $length['seriesLength'],
            'seasonsLength' => $length['seasonsLength']
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

        $trailer = Video::where('id', '=', $series['trailer'])->first(['name', 'storage']);
        
        return view('series.edit', [
            'content' => $content,
            'trailer' => $trailer,
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
