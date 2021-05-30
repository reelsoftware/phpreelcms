<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Series;
use Auth;

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
        $movies = Movie::orderByDesc('id')
            ->where([['cast', 'like', '%' . $slug . '%'], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'movies.thumbnail')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'movies.description as description',
                'movies.year as year',
                'movies.length as length',
                'movies.cast as cast',
                'movies.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

        //Gets all the series that have a cast value similar to the given slug
        $series = Series::orderByDesc('id')
            ->where([['cast', 'like', '%' . $slug . '%'], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'series.thumbnail')
            ->select(
                'series.id as id',
                'series.title as title',
                'series.description as description',
                'series.year as year',
                'series.cast as cast',
                'series.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

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

        return view(env('THEME') . '.categories.cast', [
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
        //Gets all the movies that have a genre value similar to the given slug
        $movies = Movie::orderByDesc('id')
            ->where([['genre', 'like', '%' . $slug . '%'], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'movies.thumbnail')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'movies.description as description',
                'movies.year as year',
                'movies.length as length',
                'movies.cast as cast',
                'movies.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

        //Gets all the series that have a cast value similar to the given slug
        $series = Series::orderByDesc('id')
            ->where([['genre', 'like', '%' . $slug . '%'], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'series.thumbnail')
            ->select(
                'series.id as id',
                'series.title as title',
                'series.description as description',
                'series.year as year',
                'series.cast as cast',
                'series.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

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

        return view(env('THEME') . '.categories.genre', [
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
        //Gets all the movies that have that release year
        $movies = Movie::orderByDesc('id')
            ->where([['year', '=', $year], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'movies.thumbnail')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'movies.description as description',
                'movies.year as year',
                'movies.length as length',
                'movies.cast as cast',
                'movies.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

        //Gets all the series that have a cast value similar to the given slug
        $series = Series::orderByDesc('id')
            ->where([['year', 'like', '%' . $year . '%'], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'series.thumbnail')
            ->select(
                'series.id as id',
                'series.title as title',
                'series.description as description',
                'series.year as year',
                'series.cast as cast',
                'series.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

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

        return view(env('THEME') . '.categories.release', [
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
        //Gets all the movies that have that release year
        $movies = Movie::orderByDesc('id')
            ->where([['rating', '=', $grade], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'movies.thumbnail')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'movies.description as description',
                'movies.year as year',
                'movies.length as length',
                'movies.cast as cast',
                'movies.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

        //Gets all the series that have a cast value similar to the given slug
        $series = Series::orderByDesc('id')
            ->where([['rating', 'like', '%' . $grade . '%'], ['public', '=', '1']])
            ->join('images', 'images.id', '=', 'series.thumbnail')
            ->select(
                'series.id as id',
                'series.title as title',
                'series.description as description',
                'series.year as year',
                'series.cast as cast',
                'series.genre as genre',
                'images.name as image_name',
                'images.storage as image_storage',
            )
            ->get();

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

        return view(env('THEME') . '.categories.rating', [
            'content' => $results, 
            'subscribed' => $subscribed,
            'grade' => $grade,
        ]);
    }
}
