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
     * Checks if there is a child theme defined, if not thn it returns the active theme, else it's child theme
     * 
     */
    public static function getActiveTheme(): string
    {
        if(File::isDirectory(resource_path("themes/child-" . config('app.theme'))))
            return 'child-' . config('app.theme');
        else
            return config('app.theme');
    }

    /**
     * Return the file path of a file either from the theme or child theme 
     * This should be used for anything that is not a view
     *
     * @param string $path path to the file to be checked (starting from theme root)
     * 
     */
    public static function getFilePath(string $path)
    {
        //Path to the file inside the theme
        $themePath = resource_path("themes/" . config('app.theme') . "/$path");

        //Path to the file inside the child theme
        $childThemePath = resource_path("themes/" . "child-" . config('app.theme') . "/$path");

        //If the file exist in the child theme then return the child theme
        if(File::exists($childThemePath))
            return $childThemePath;
        else if(File::exists($themePath))
            return $themePath;
        else 
            return null;
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
     * Return all the available base themes (not child themes)
     * 
     */
    public static function getBaseThemes(): array
    {
        $allThemes = Theme::getThemes();
        $baseThemes = [];

        foreach($allThemes as $theme)
        {
            //Remove child themes from the list
            if(substr($theme, 0, 6) != "child-")
                array_push($baseThemes, $theme);
        }

        return $baseThemes;
    }

    /**
     * Return all the details for a given array of themes
     * 
     * @param array $themes list of the themes we are requesting details for
     */
    public static function getThemesDetails(array $themes): array
    {
        $themeDetails = [];

        foreach($themes as $theme)
        {
            $themeDetails[$theme]['config'] = Theme::getConfig($theme);
            $themeDetails[$theme]['cover'] = Theme::getCover($theme);
            $themeDetails[$theme]['directoryName'] = $theme;
        }

        return $themeDetails;
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

    /**
     * Generates the child theme directory and it's subdirectories
     * 
     * @param string $theme name of the theme
     */
    public static function generateChildTheme($theme)
    {
        $path = resource_path('themes/child-' . $theme);
        $directories = ['auth', 'categories', 'css', 'episodes', 'home', 'img', 'js', 'lang', 'layouts', 'movie', 'pagination', 'search', 'series', 'subscribe', 'trailer', 'user'];

        //Generate the root child theme directory
        if(!File::isDirectory($path))
            File::makeDirectory($path);

        //Generate the child theme directories
        foreach($directories as $directory)
            if(!File::isDirectory("$path//$directory"))
                File::makeDirectory("$path//$directory");
    }

    /**
     * Returns an array containing the basic structure of a theme
     *
     * @return array
     */
    public static function getDefaultThemeDirectories()
    {
        return [
            'auth' => ['forgot-password.blade.php', 'login.blade.php', 'register.blade.php', 'reset-password.blade.php'], 
            'categories' => ['cast.blade.php', 'genre.blade.php', 'rating.blade.php', 'release.blade.php'], 
            'css', 
            'episodes' => ['show.blade.php'], 
            'home' => ['home.blade.php'],
            'img', 
            'js', 
            'lang' => ['default' => ['default.json']], 
            'layouts' => ['layout.blade.php'], 
            'movie' => ['index.blade.php', 'show.blade.php'], 
            'pagination' => ['simple-pagination.blade.php'], 
            'search' => ['index.blade.php'], 
            'series' => ['index.blade.php', 'show.blade.php'], 
            'subscribe' => ['index.blade.php'], 
            'trailer' => ['show.blade.php'], 
            'user' => ['index.blade.php']
        ];
    }

    /**
     * Generates the theme directory, subdirectories and mandatory files
     * 
     * @param string $theme name of the theme to be created
     */
    public static function generateTheme($theme)
    {
        $path = resource_path('themes/' . $theme);
        $directories = Theme::getDefaultThemeDirectories();

        //Generate the root theme directory
        if(!File::isDirectory($path))
            File::makeDirectory($path);

        //Generate the theme directories
        foreach($directories as $directory)
            if(!File::isDirectory("$path//$directory"))
                File::makeDirectory("$path//$directory");

    }

    /**
     * Returns true if a theme is found, false if not
     * 
     * @param string $theme name of the theme to be searched for
     */
    public static function findTheme($theme): bool
    {
        $path = resource_path('themes/' . $theme);

        if(File::isDirectory($path))
            return true;
        else
            return false;          
    }

    /**
     * Remove theme from themes folder
     * 
     * @param string $theme name of the theme
     * 
     * @return bool returns true if succeeds, false if not
     */
    public static function deleteTheme($theme): bool
    {
        return File::deleteDirectory(resource_path('themes/' . $theme));
    }
}