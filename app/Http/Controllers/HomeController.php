<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Movie;
use App\Models\Series;
use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        //Multiple subscription types
        //$defaultSubscription = Setting::where('setting', '=', 'default_subscription')->first()['value'];
        
        if($user != null)
        {
            $defaultSubscription = 'default';
            $subscription = $user->subscribed($defaultSubscription);
        }
        else
        {
            $subscription = false;
        }

        //Get the latest movies
        $movies = Movie::where('public', '=', '1')
            ->join('images', 'images.id', '=', 'movies.thumbnail')
            ->orderByDesc('movies.id')
            ->select([
                'movies.id as movie_id',
                'images.name as image_name',
                'images.storage as image_storage',
            ])
            ->limit(6)
            ->get();

        //Get the latest series
        $series = Series::where('public', '=', '1')
            ->join('images', 'images.id', '=', 'series.thumbnail')
            ->orderByDesc('series.id')
            ->select([
                'series.id as series_id',
                'images.name as image_name',
                'images.storage as image_storage',
            ])
            ->limit(6)
            ->get();
                
        return view(env('THEME') . '.index', [
            'subscribed' => $subscription,
            'movies' => $movies,
            'series' => $series
        ]);

    }
}
