<?php
namespace App\Helpers\Module; 

use Illuminate\Support\Facades\View;
use File;
use Module;

class ModuleHandler
{
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
}