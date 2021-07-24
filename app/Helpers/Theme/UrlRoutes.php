<?php
namespace App\Helpers\Theme; 

class UrlRoutes
{
    /**
     * Returns URL to the subscription list page
     * 
     */
    public static function subscriptionsList()
    {
        return route('subscribe');
    }

    /**
     * Returns URL to a search result based on a given query
     * 
     * @param string $query to search for
     */
    public static function search($query)
    {
        return route('search', ['query' => $query]);
    }

    /**
     * Returns URL, POST method, to query the database
     * To call the URL it needs a form parameter called query, that must be a string, max:255
     * 
     */
    public static function searchPost()
    {
        return route('searchPost');
    }

    /**
     * Returns URL to the all movies page
     * 
     */
    public static function allMovies()
    {
        return route('movies');
    }

    /**
     * Returns URL to the all movies page
     * 
     */
    public static function allSeries()
    {
        return route('series');
    }

    /**
     * Returns URL to the a particular movie based on an id
     * 
     * @param int $id of the movie to search for
     */
    public static function movie($id)
    {
        return route('movieShow', ['id' => $id]);
    }

    /**
     * Returns URL to the a particular movie trailer based on an id
     * 
     * @param int $id of the movie trailer to search for
     */
    public static function movieTrailer($id)
    {
        return route('trailerMovieShow', ['id' => $id]);
    }

    /**
     * Returns URL to the a particular series based on an id
     *
     * @param int $id of the series to search for 
     */
    public static function series($id)
    {
        return route('seriesShow', ['id' => $id]);
    }

    /**
     * Returns URL to the a particular season trailer based on an id
     *
     * @param int $id of the season trailer to search for 
     */
    public static function seasonTrailer($id)
    {
        return route('trailerSeasonShow', ['id' => $id]);
    }

    /**
     * Returns URL to the a particular episode based on an id
     *
     * @param int $id of the episode to search for 
     */
    public static function episode($id)
    {
        return route('episodeShow', ['id' => $id]);
    }


    /**
     * Returns URL to the home
     *
     */
    public static function home()
    {
        return route('home');
    }

    /**
     * Returns URL to the login page
     *
     */
    public static function login()
    {
        return route('login');
    }


    /**
     * Returns URL to the register page
     *
     */
    public static function register()
    {
        return route('register');
    }
}