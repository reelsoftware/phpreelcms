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

if (!function_exists('get_trailer_url')) 
{
    function get_trailer_url($trailerId)
    {
        return route('trailerMovieShow', ['id' => $trailerId]);
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

