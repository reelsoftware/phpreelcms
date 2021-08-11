<?php

namespace App\Http\Controllers;

use App\Helpers\Content\ContentHandler;
use App\Helpers\Theme\Theme;
use App\Helpers\User\UserHandler; 

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
                
        return Theme::view('home.home', [
            'subscribed' => $subscription,
            'movies' => $movies,
            'series' => $series
        ]);

    }
}
