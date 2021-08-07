<?php
namespace App\Helpers\Module; 

use Illuminate\Support\Facades\View;
use File;
use Module;

class ModuleHandler
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
    public static function view(string $view, array $data = [])
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
     * Return all the available modules
     * 
     */
    public static function getModules()
    {
        return array_map('basename', File::directories(base_path('Modules')));
    }

    /**
     * Return all the details for a given array of modules
     * 
     * @param array $modules list of the modules we are requesting details for
     */
    public static function getModulesDetails(array $modules): array
    {
        $modulesDetails = [];

        foreach($modules as $module)
        {
            $modulesDetails[$module]['config'] = self::getConfig($module);
            $modulesDetails[$module]['cover'] = self::getCover($module);
            $modulesDetails[$module]['directoryName'] = $module;
        }

        return $modulesDetails;
    }

    /**
     * Return the config.json file from the module
     *
     * @param string $module name of the module
     * 
     */
    public static function getConfig(string $module)
    {
        $configPath = base_path('Modules/'. $module . '/config.json');

        if(File::exists($configPath))
            return json_decode(implode("", file($configPath)), true);
    }

    /**
     * Return the cover image from the module folder
     * 
     * @param string $module name of the module
     * 
     * @return string url to the cover image
     */
    public static function getCover(string $module): string
    {
        return route('moduleCover', ['module' => $module]);
    }

    /**
     * Generates the child theme directory and it's subdirectories
     * 
     * @param string $theme name of the theme
     */
    public static function generateChildTheme($theme)
    {
        $path = resource_path('themes/child-' . $theme);
        $directories = array_keys(Theme::getDefaultThemeDirectories());

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
            'css' => [], 
            'episodes' => ['show.blade.php'], 
            'home' => ['home.blade.php'],
            'error' => ['error.blade.php'],
            'img' => [], 
            'js' => [], 
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
     * Creates the files and directories from the directories array
     * 
     * @param string $directories array of the directories
     * @param string $path to where the files or directories are going to be created
     */
    public static function createFiles($directories, $path)
    {
        foreach($directories as $key => $value)
        {
            if(gettype($value) == 'array')
            {
                $tempPath = $path . '/' . $key;

                if(!File::isDirectory($tempPath))
                    File::makeDirectory($tempPath);

                Theme::createFiles($value, $tempPath);
            }   
            else if(!File::exists($path . '/' . $value))
                File::put($path . '/' . $value, '');
        }
    }

    /**
     * Generates the config file for a new theme
     * 
     * @param string $theme name of the theme to be created
     */
    public static function generateConfig($module, $moduleName, $description, $author, $moduleUrl, $version, $license, $licenseUrl)
    {
        $path = base_path("Modules/$module/config.json");
        $config = [
            "Module name" => $moduleName,
            "Description" => $description,
            "Author" => $author,
            "Module URL" => $moduleUrl,
            "Version" => $version,
            "License" => $license,
            "License URL" => $licenseUrl
        ];

        $json = json_encode($config, JSON_PRETTY_PRINT);
        
        if(!File::exists($path))
            File::put($path, $json);
    }

    /**
     * Generates the default cover image
     * 
     * @param string $theme name of the theme
     */
    public static function generateDefaultCover($module)
    {
        $path = base_path("Modules/$module");

        if(File::isDirectory($path))
            File::copy(resource_path('themeCover/cover.jpg'), "$path/cover.jpg");
    }

    /**
     * Returns true if a module is found, false if not
     * 
     * @param string $module module of the theme to be searched for
     */
    public static function findModule($module): bool
    {
        $path = base_path('Modules/' . $module);

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