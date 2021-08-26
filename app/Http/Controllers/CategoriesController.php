<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Series;
use App\Helpers\Categories\CategoriesHandler;
use App\Helpers\User\UserHandler;
use App\Helpers\Theme\Theme;

class CategoriesController extends Controller
{
    /**
     * Display the movies and series coresponding to that particular category and value
     *
     * @param  string  $categoryName name of the category to select content for
     * @param  string  $value to search for 
     * @return \Illuminate\Http\Response
     */
    public function index($categoryName, $value)
    {
        //Gets all the movies that have a cast value similar to the given value
        $movies = CategoriesHandler::getMovieByCategory($categoryName, $value);

        //Gets all the series that have a cast value similar to the given value
        $series = CategoriesHandler::getSeriesByCategory($categoryName, $value);

        $results = [];

        //Add movies to results array
        foreach($movies as $movie)
            $results[] = $movie;

        //Add series to results array
        foreach($series as $s)
            $results[] = $s;
        
        shuffle($results);

        $results = collect($results)->paginate(9);

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('categories.index', [
            'content' => $results, 
            'subscribed' => $subscribed,
            'value' => $value,
        ]);
    }
}
