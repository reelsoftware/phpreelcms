<?php
namespace App\Helpers\Theme; 

class Utilities
{
    /**
     * Render a specific pagination file
     *
     * @param string $content content to be paginated
     * @param array $paginationFileName name of the view situated inside the pagination folder to be paginated
     * 
     */
    public static function pagination($content, $paginationFileName)
    {
        $filePath = 'pagination.' . $paginationFileName;

        $theme = null;

        //If the child theme file exists then render that file else render the theme file
        if(Theme::existsChildView($filePath))
        {
            $theme = 'child-' . config('app.theme') . '.' . $filePath;
        }
        else
        {
            $theme = config('app.theme') . '.' . $filePath;;
        }

        return $content->links($theme);
    }

    /**
     * Returns an excerpt from a given input text
     *
     * @param string $text to be excerpted
     * @param int $length of the resulting text
     * @param string $trimMarker string to be added after the chunk of text
     * 
     */
    public static function excerpt(string $text, int $length, string $trimMarker)
    {
        return mb_strimwidth($text, 0, $length, $trimMarker);
    }

    /**
     * Converts time from seconds to HH:MM:SS
     *
     * @param int $timestamp represents the length in seconds of a particular piece o content
     */
    public static function timeHMS($timestamp)
    {
        return gmdate("H:i:s", $timestamp);
    }

    /**
     * Price is stored in cents so it mush be converted back to a format with decimal point
     *
     * @param int $price value stored in the db
     */
    public static function price($price)
    {
        return (float)$price/100;
    }

    /**
     * Returns the current year
     *
     * @return string
     */
    public static function currentYear(): string
    {
        return (string)date("Y");
    }
}