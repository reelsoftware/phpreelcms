<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Container\Container;
use App\Helpers\Content\ContentHandler;
use App\Helpers\User\UserHandler;
use Auth;

class SearchController extends Controller
{
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
        
        $movies = ContentHandler::findMovies($q);
        $series = ContentHandler::findSeries($q);
        
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
