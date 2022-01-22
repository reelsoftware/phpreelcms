<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SeriesResource;
use Auth;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Video;
use App\Models\Category;
use App\Helpers\Content\ContentHandler;
use App\Helpers\User\UserHandler;
use App\Helpers\Theme\Theme;
use App\Helpers\Content\SeriesBuilder;
use Exception;
use Response;
use TypeError;
use ValueError;

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
     * Display a paginated list of series.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $series = ContentHandler::getLatestSeriesPaginate($request->perPage); 
        }
        catch(TypeError $error)
        {
            return response()->json(['error' => $error->getMessage()], 500);
        }
        catch(ValueError $error)
        {
            return response()->json(['error' => $error->getMessage()], 500);
        }
 
        return response()->json($series, 200);
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
        $response = [];
        
        $series = ContentHandler::getSeries($id);
        $response['data'] = $series;
        
        if(empty($series->toArray()))
        {
            return response()->json(['error' => 'Series not found.'], 404);
        }
        
        $response['links'] = [
            'seasons' => [
                'href' => route('seasonsIndex') . '?series=' . $id,
                'rel' => 'seasons',
                'type' => 'GET'
            ]
        ];

        return response()->json($response, 200);
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
