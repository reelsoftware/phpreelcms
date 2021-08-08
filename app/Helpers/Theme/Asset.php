<?php
namespace App\Helpers\Theme; 

class Asset
{
    /**
     * Return URL of a particular js file situated in the current active theme
     *
     * @param string $scriptName
     * 
     */
    public static function js(string $scriptName)
    {
        return route('jsAsset', ['scriptName' => $scriptName]);
    }

    /**
     * Return URL of a particular css file situated in the current active theme
     *
     * @param string $styleName
     * 
     */
    public static function css(string $styleName)
    {
        return route('cssAsset', ['styleName' => $styleName]);
    }

    /**
     * Return URL of a particular video file
     *
     * @param string $videoName name of the video to be returned
     * @param string $videoStorage storage of that particular video
     * 
     */
    public static function video(string $videoName, string $videoStorage)
    {
        if(in_array($videoStorage, ['local', 's3']))
            return route('fileResource', ['fileName' => $videoName, 'storage' => $videoStorage]);
        else if($videoStorage == 'youtube')
            return "https://www.youtube.com/embed/$videoName";
        else if($videoStorage == 'vimeo')
            return "https://player.vimeo.com/video/$videoName";
        else
            return null;
    }

    /**
     * Return URL of a particular image file
     *
     * @param string $imageName name of the image to be returned
     * @param string $imageStorage storage of that particular image
     * 
     */
    public static function image(string $imageName, string $imageStorage)
    {
        return route('fileResourceImage', ['fileName' => $imageName, 'storage' => $imageStorage]);
    }

    /**
     * URL for a image situated inside the img directory of a theme or child theme
     *
     * @param string $imageName situated in the img directory
     * 
     */
    public static function themeImage(string $imageName)
    {
        return route('imageAsset', ['imageName' => $imageName]);
    }

    /**
     * Return URL of a particular video file that is associated with a content type (movie, series)
     *
     * @param $item movie or series object
     * 
     */
    public static function item($item)
    {
        if(with($item)->getTable() == 'movies')
            return route('movieShow', ['id' => $item->id]);
        else if(with($item)->getTable() == 'series')
            return route('seriesShow', ['id' => $item->id]); 
        else
            return null;
    }
}