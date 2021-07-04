<?php
namespace App\Helpers\Theme; 

use Illuminate\Support\Facades\View;
use File;

class Theme
{
    /**
     * Return true if there is a child view and false if there is not a child view
     *
     * @param string $view path to the view to be checked
     * 
     */
    public static function existsChildView(string $view): bool
    {
        //Path to the file inside the theme
        $themePath = config('app.theme') . '.' . $view;

        //Path to the file inside the child theme
        $childThemePath = 'child-' . $themePath;

        //If the child theme file exists then render that file else render the theme file
        if(View::exists($childThemePath))
            return true;
        else
            return false;
    }

    /**
     * Return a specific view
     * If there is a child theme set then return that file, else return the theme file
     *
     * @param string $view path to the view to be rendered
     * @param array $data data to be passed to the view
     * 
     */
    public static function view(string $view, array $data)
    {
        //If the child theme file exists then render that file else render the theme file
        if(Theme::existsChildView($view))
        {
            $childThemePath = 'child-' . config('app.theme') . '.' . $view;
            return view($childThemePath, $data);
        }      
        else
        {
            $themePath = config('app.theme') . '.' . $view;
            return view($themePath, $data);
        }
    }

    /**
     * Return all the available themes and child themes
     * 
     */
    public static function getThemes()
    {
        return array_map('basename', File::directories(resource_path('themes')));
    }

    /**
     * Return the config.json file from the theme
     *
     * @param string $theme name of the theme
     * 
     */
    public static function getConfig(string $theme)
    {
        return json_decode(implode("", file(resource_path('themes/'. $theme . '/config.json'))), true);
    }

    /**
     * Return the cover image from the theme folder
     * 
     * @param string $theme name of the theme
     * 
     * @return string url to the cover image
     */
    public static function getCover(string $theme): string
    {
        return route('themeCover', ['theme' => $theme]);
    }
}