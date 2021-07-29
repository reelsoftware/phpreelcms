<?php
namespace App\Helpers\Theme; 

class UrlRoutes
{
    /**
     * Returns URL to the subscription list page
     * 
     */
    public static function subscribe()
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
     * POST: Query the database to search for a movie or series
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * @param string query maximum 255 characters, word or group of words to search for in the database
     * 
     */
    public static function searchPost()
    {
        return route('searchPost');
    }

    /**
     * POST: Reset the password of a user
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * @param string email address to which the account is registered
     * 
     */
    public static function resetPasswordPost()
    {
        return route('password.email');
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
     * POST: Reset the password of a user
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * @param string email address to which the account is registered
     * @param string password that corresponds to the email
     * @param string remember checkbox if the user should be remembered when he comes back
     * 
     */
    public static function loginPost()
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

    /**
     * POST: Register new account
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * @param string name of the user
     * @param string email
     * @param string password
     * @param string password_confirmation
     * 
     */
    public static function registerPost()
    {
        return route('register');
    }

    /**
     * Returns URL to the user config page
     *
     */
    public static function user()
    {
        return route('user');
    }

    /**
     * POST: Logout from the account
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     */
    public static function logoutPost()
    {
        return route('logout');
    }

    /**
     * POST: Update the language of a particular user
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * @param string language id to be set as default for the user
     * 
     */
    public static function userUpdateLanguagePost()
    {
        return route('userUpdateLanguage');
    }

    /**
     * POST: Redirect user to stripe checkout
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * 
     */
    public static function userManageSubscriptionPost()
    {
        return route('userManageSubscription');
    }

    /**
     * POST: Redirect user to stripe checkout
     * 
     * @param string _token with every post request with Laravel you must add a hidden input with the value of csrf_token() or just use @csrf Blade directive
     * @param string plan name stripe that the user wants to subscribe to
     * 
     */
    public static function subscribeStorePost()
    {
        return route('subscribeStore');
    }
}