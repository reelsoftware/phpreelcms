<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Movie;
use App\Models\Series;
use App\Helpers\Content\ContentHandler;
use App\Helpers\Theme\Theme;
user App\Helpers\User\UserHandler; 
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
        $subscription = UserHandler::checkSubscription();

        //Get the latest movies
        $movies = ContentHandler::getLatestMovies(6);

        //Get the latest series
        $series = ContentHandler::getLatestSeries(6);
                
        return Theme::view('index', [
            'subscribed' => $subscription,
            'movies' => $movies,
            'series' => $series
        ]);

    }
}
