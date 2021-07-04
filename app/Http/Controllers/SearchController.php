<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Container\Container;
use Auth;

class SearchController extends Controller
{
    private function getMovies($query)
    {
        //Search the database for each keyword one by one
        $movies = Movie::orderByDesc('id')
        ->where('title', 'like', '%' . $query[0] . '%')
        ->orWhere('description', 'like', '%' . $query[0] . '%');

        for($i=1;$i<count($query);$i++)
        {
        $movies = $movies
            ->orWhere('title', 'like', '%' . $query[$i] . '%')
            ->orWhere('description', 'like', '%' . $query[$i] . '%');
        }


        $movies = $movies
        ->where('public', '=', '1')
        ->join('images', 'images.id', '=', 'movies.thumbnail')
        ->select(
            'movies.id as id',
            'movies.title as title',
            'movies.description as description',
            'movies.length as length',
            'images.name as image_name',
            'images.storage as image_storage',
        )
        ->get();

        return $movies;
    }

    private function getSeries($query)
    {
        //Search the database for each keyword one by one
        $series = Series::orderByDesc('id')
            ->where('title', 'like', '%' . $query[0] . '%')
            ->orWhere('description', 'like', '%' . $query[0] . '%');

        for($i=1;$i<count($query);$i++)
        {
        $series = $series
            ->orWhere('title', 'like', '%' . $query[$i] . '%')
            ->orWhere('description', 'like', '%' . $query[$i] . '%');
        }

        $series = $series
        ->where('public', '=', '1')
        ->join('images', 'images.id', '=', 'series.thumbnail')
            ->select(
                'series.id as id',
                'series.title as title',
                'series.description as description',
                'images.name as image_name',
                'images.storage as image_storage',
            )
        ->get();

        return $series;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($query)
    {
        //Query for movies
        //Explode the query string 
        $q = explode(' ', htmlspecialchars($query));
        $requestQuery = $query;
        
        $movies = $this->getMovies($q);
        $series = $this->getSeries($q);
        
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

        return view(env('theme') . '.search.index', [
            'content' => $results,
            'subscribed' => $subscribed,
            'query' => $query
        ]);
    }

    public function search(Request $request) 
    {
        $validated = $request->validate([
            'query' => 'required|string|max:255',
        ]);

        return redirect(route('search', [
            'query' => $request['query'],
        ]));
    }
}
