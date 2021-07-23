<?php

use App\Helpers\Theme\Theme;

if (!function_exists('get_release_url')) 
{
    function get_release_category_url($year)
    {
        return route('releaseShow', ['year' => $year]);
    }
}

if (!function_exists('get_genre_category_url')) 
{
    function get_genre_category_url($genre)
    {
        return route('genreShow', ['slug' => $genre]);
    }
}

if (!function_exists('get_cast_actor_category_url')) 
{
    function get_cast_actor_category_url($actor)
    {
        return route('castShow', ['slug' => $actor]);
    }
}

if (!function_exists('get_rating_category_url')) 
{
    function get_rating_category_url($rating)
    {
        return route('ratingShow', ['grade' => $rating]);
    }
}

if (!function_exists('get_js_url')) 
{
    function get_js_url($scriptName)
    {
        return route('jsAsset', ['scriptName' => $scriptName]);
    }
}

if (!function_exists('get_css_url')) 
{
    function get_css_url($styleName)
    {
        echo route('cssAsset', ['styleName' => $styleName]);
    }
}

if (!function_exists('get_video_url')) 
{
    function get_video_url($video_name, $video_storage)
    {
        if(in_array($video_storage, ['local', 's3']))
            return route('fileResource', ['fileName' => $video_name, 'storage' => $video_storage]);
        else if($video_storage == 'youtube')
            return "https://www.youtube.com/embed/$video_name";
        else if($video_storage == 'vimeo')
            return "https://player.vimeo.com/video/$video_name";
        else
            return null;
    }
}

if (!function_exists('get_item_url')) 
{
    function get_item_url($item)
    {
        if(with($item)->getTable() == 'movies')
            return route('movieShow', ['id' => $item->id]);
        else if(with($item)->getTable() == 'series')
            return route('seriesShow', ['id' => $item->id]); 
        else
            return null;
    }
}

if (!function_exists('get_image_url')) 
{
    function get_image_url($imageName, $imageStorage)
    {
        return route('fileResourceImage', ['fileName' => $imageName, 'storage' => $imageStorage]);
    }
}

/**
 * URL for a image situated inside the img folder of a theme or child theme
 *
 * @param string $content content to be paginated
 * @param array $paginationFileName name of the view situated inside the pagination folder to be paginated
 * 
 */
if (!function_exists('get_theme_image_url')) 
{
    function get_theme_image_url($imageName)
    {
        return route('imageAsset', ['imageName' => $imageName]);
    }
}

/**
 * Render a specific pagination file
 *
 * @param string $content content to be paginated
 * @param array $paginationFileName name of the view situated inside the pagination folder to be paginated
 * 
 */
if (!function_exists('get_pagination')) 
{
    function get_pagination($content, $paginationFileName)
    {
        $filePath = 'pagination.' . $paginationFileName;

        $theme = null;

        //If the child theme file exists then render that file else render the theme file
        if(Theme::existsChildView($filePath))
            $theme = 'child-' . config('app.theme') . '.' . $filePath;
        else
            $theme = config('app.theme') . '.' . $filePath;;

        return $content->links($theme);
    }
}

/**
 * Returns an excerpt from a given input text
 *
 * @param string $text to be excerpted
 * @param int $length of the resulting text
 * @param string $trimMarker string to be added after the chunk of text
 * 
 */
if (!function_exists('get_excerpt')) 
{
    function get_excerpt(string $text, int $length, string $trimMarker)
    {
        return mb_strimwidth($text, 0, $length, $trimMarker);
    }
}

/**
 * Returns URL to the subscription list page
 * 
 */
if (!function_exists('get_subscription_list_url')) 
{
    function get_subscription_list_url()
    {
        echo route('subscribe');
    }
}

/**
 * Returns URL to a search result based on a given query
 * 
 * @param string $query to search for
 */
if (!function_exists('get_search_result_url')) 
{
    function get_search_result_url($query)
    {
        echo route('search', ['query' => $query]);
    }
}

/**
 * Returns URL, POST method, to query the database
 * To call the URL it needs a form parameter called query, that must be a string, max:255
 * 
 */
if (!function_exists('get_search_post_url')) 
{
    function get_search_post_url()
    {
        echo route('searchPost');
    }
}

/**
 * Returns URL to the all movies page
 * 
 */
if (!function_exists('get_all_movies_url')) 
{
    function get_all_movies_url()
    {
        echo route('movies');
    }
}

/**
 * Returns URL to the all movies page
 * 
 */
if (!function_exists('get_all_series_url')) 
{
    function get_all_series_url()
    {
        echo route('series');
    }
}

/**
 * Returns URL to the a particular movie based on an id
 * 
 * @param int $id of the movie to search for
 */
if (!function_exists('get_movie_url')) 
{
    function get_movie_url($id)
    {
        echo route('movieShow', ['id' => $id]);
    }
}

/**
 * Returns URL to the a particular movie trailer based on an id
 * 
 * @param int $id of the movie trailer to search for
 */
if (!function_exists('get_movie_trailer_url')) 
{
    function get_movie_trailer_url($id)
    {
        echo route('trailerMovieShow', ['id' => $id]);
    }
}

/**
 * Returns URL to the a particular series based on an id
 *
 * @param int $id of the series to search for 
 */
if (!function_exists('get_series_url')) 
{
    function get_series_url($id)
    {
        echo route('seriesShow', ['id' => $id]);
    }
}

/**
 * Returns URL to the a particular season trailer based on an id
 *
 * @param int $id of the season trailer to search for 
 */
if (!function_exists('get_season_trailer_url')) 
{
    function get_season_trailer_url($id)
    {
        echo route('trailerSeasonShow', ['id' => $id]);
    }
}

/**
 * Returns URL to the a particular episode based on an id
 *
 * @param int $id of the episode to search for 
 */
if (!function_exists('get_episode_url')) 
{
    function get_episode_url($id)
    {
        echo route('episodeShow', ['id' => $id]);
    }
}

/**
 * Returns URL to the home
 *
 */
if (!function_exists('get_home_url')) 
{
    function get_home_url()
    {
        echo route('home');
    }
}

/**
 * Returns URL to the login page
 *
 */
if (!function_exists('get_login_url')) 
{
    function get_login_url()
    {
        echo route('login');
    }
}

/**
 * Returns URL to the register page
 *
 */
if (!function_exists('get_register_url')) 
{
    function get_register_url()
    {
        echo route('register');
    }
}
