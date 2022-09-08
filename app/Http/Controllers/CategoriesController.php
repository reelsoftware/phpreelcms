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
     * Display the movies having assigned that cast
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function showCast($slug)
    {
        //Gets all the movies that have a cast value similar to the given slug
        $movies = CategoriesHandler::getMovieByCategory('cast', $slug);

        //Gets all the series that have a cast value similar to the given slug
        $series = CategoriesHandler::getSeriesByCategory('cast', $slug);

        $results = [];

        //Add movies to results array
        foreach($movies as $movie)
        {
            $results[] = $movie;
        }

        //Add series to results array
        foreach($series as $s)
        {
            $results[] = $s;
        }
        
        shuffle($results);

        $results = collect($results)->paginate(9);

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('categories.cast', [
            'content' => $results, 
            'subscribed' => $subscribed,
            'cast' => $slug,
        ]);
    }

    /**
     * Display the movies having assigned that genre
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function showGenre($slug)
    {
        //Gets all the movies that have a genre value similar to the given genre
        $movies = CategoriesHandler::getMovieByCategory('genre', $slug);

        //Gets all the series that have a genre value similar to the given genre
        $series = CategoriesHandler::getSeriesByCategory('genre', $slug);

        $results = [];

        //Add movies to results array
        foreach($movies as $movie)
        {
            $results[] = $movie;
        }

        //Add series to results array
        foreach($series as $s)
        {
            $results[] = $s;
        }
        
        shuffle($results);

        $results = collect($results)->paginate(9);

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('categories.genre', [
            'content' => $results, 
            'subscribed' => $subscribed,
            'genre' => $slug,
        ]);
    }

    /**
     * Display the movies having that release year
     *
     * @param  string  $year
     * @return \Illuminate\Http\Response
     */
    public function showRelease($year)
    {
        //Gets all the movies that have a year value similar to the given year
        $movies = CategoriesHandler::getMovieByCategory('year', $year);

        //Gets all the series that have a year value similar to the given year
        $series = CategoriesHandler::getSeriesByCategory('year', $year);

        $results = [];

        //Add movies to results array
        foreach($movies as $movie)
        {
            $results[] = $movie;
        }

        //Add series to results array
        foreach($series as $s)
        {
            $results[] = $s;
        }
        
        shuffle($results);

        $results = collect($results)->paginate(9);    

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('categories.release', [
            'content' => $results, 
            'subscribed' => $subscribed,
            'year' => $year,
        ]);
    }

        /**
     * Display the movies having that grade
     *
     * @param  string  $grade
     * @return \Illuminate\Http\Response
     */
    public function showRating($grade)
    {
        //Gets all the movies that have a rating value similar to the given grade
        $movies = CategoriesHandler::getMovieByCategory('rating', $grade);

        //Gets all the series that have a rating value similar to the given grade
        $series = CategoriesHandler::getSeriesByCategory('rating', $grade);

        $results = [];

        //Add movies to results array
        foreach($movies as $movie)
        {
            $results[] = $movie;
        }

        //Add series to results array
        foreach($series as $s)
        {
            $results[] = $s;
        }

        shuffle($results);

        $results = collect($results)->paginate(9);

        $subscribed = UserHandler::checkSubscription();

        return Theme::view('categories.rating', [
            'content' => $results, 
            'subscribed' => $subscribed,
            'grade' => $grade,
        ]);
    }
}
