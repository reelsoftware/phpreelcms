<?php
namespace App\Helpers\Translation; 

use App\Models\Translation;
use App\Helpers\Theme\Theme;
use File;

class TranslationHandler
{
    /**
     * Return the latest available translations
     *
     * @param int $limit how many of the latest series to get
     */
    public static function getTranslationsSimplePaginate(int $limit)
    {
        //Error handling
        if($limit < 0)
            throw new Exception("\$limit must be a non-negative integer");

        return Translation::orderByDesc('id')->simplePaginate($limit);
    }

    /**
     * Return the content of the default translation file from either theme or child theme (as json)
     *
     */
    public static function getDefaultTranslationFileContent()
    {
        $languageFile = json_decode(File::get(Theme::getFilePath('lang\default\default.json')), true);

        return $languageFile;
    }

    /**
     * Return the content of the default translation file from either theme or child theme (as json)
     *
     * @param string $language name of the requested language file
     */
    public static function getTranslationFileContent(string $language)
    {
        return json_decode(File::get(Theme::getFilePath("lang\\$language.json")), true);
    }

    /**
     * Delete the specified translation file
     *
     * @param string $language name of the requested language file
     */
    public static function deleteTranslationFile(string $language)
    {
        //Delete translation file from theme
        File::delete(Theme::getFilePath("lang\\$language.json"));

        //Delete translation file from resources/lang
        File::delete(resource_path("lang\\$language.json"));
    }

    /**
     * Delete the specified translation file
     *
     * @param string $language name of the requested language file
     * @param string $fileContent content to be saved as a json file
     */
    public static function saveTranslationFile(string $language, $fileContent)
    {
        File::put(resource_path("themes\\" . Theme::getActiveTheme() . "\lang\\$language.json"), json_encode($fileContent));

        //Copy the language files from theme folder to resources/lang 
        Theme::syncLang();
    }
}