<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ThemeComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Return a source html tag for the html5 video component
         * 
         * @param string $fileName Name of the video file
         * @param string $fileStorage What storage medium was used to store the video
         */
        Blade::directive('html5Source', function ($expression) {
            //Get the variables from the expression
            $params = explode(',', $expression);
            $fileName = $params[0];
            $fileStorage = $params[1];

            $php = "<?php 
                echo route('fileResource', ['fileName' => $fileName, 'storage' => $fileStorage])
            ?>";

            $html = "<source src=\"$php\">";

            return $html;
        });

        /**
         * Return the vimeo embedded video
         * 
         * @param string $expression ID of the vimeo video
         */
        Blade::directive('vimeoEmbed', function ($expression) {
            $php = "<?php echo $expression ?>";
            $html = "<iframe src=\"https://player.vimeo.com/video/$php\"></iframe>";

            return $html;
        });

        /**
         * Return the youtube embedded video
         * 
         * @param string $expression ID of the youtube video
         */
        Blade::directive('youtubeEmbed', function ($expression) {
            $php = "<?php echo $expression ?>";
            $html = "<iframe src=\"https://www.youtube.com/embed/$php\"></iframe>";

            return $html;
        });

        //Custom if directives
        /**
         * Display vimeo content only
         * 
         * @param string $expression Storage medium used for the resource
         */
        Blade::if('vimeo', function ($expression) {
            return $expression === "vimeo";
        });

        /**
         * Display html5 content only
         * 
         * @param string $expression Storage medium used for the resource
         */
        Blade::if('html5', function ($expression) {
            return (($expression === "local") || ($expression === "s3"));
        });

        /**
         * Display youtube content only
         * 
         * @param string $expression Storage medium used for the resource
         */
        Blade::if('youtube', function ($expression) {
            return $expression === "youtube";
        });

        //Assets directives
        //Js assets
        /**
         * Returns a script tag with the requested local or external script
         * 
         * @param string $scriptName Name of the script file 
         * @param string $scriptScope Can be local (stored in the theme folder inside the js folder) or external (via url, cdn)
         * 
         */
        Blade::directive('scriptJs', function ($expression) {
            //Get the variables from the expression
            $params = explode(',', $expression);
            $scriptName = $params[0];
            $scriptScope = trim($params[1]);

            if(strtolower($scriptScope) == 'local')
                $php = "<?php echo route('jsAsset', ['scriptName' => $scriptName]) ?>";
            else if(strtolower($scriptScope) == 'external')
                $php = "<?php echo $scriptName ?>";

            $html = "<script type=\"text/javascript\" src=\"$php\"></script>";

            return $html;
        });

        //CSS assets
        /**
         * Returns a css file 
         * 
         * @param string $styleName Name of the script file 
         * @param string $styleScope Can be local (stored in the theme folder inside the js folder) or external (via url, cdn)
         */
        Blade::directive('styleCss', function ($expression) {
            //Get the variables from the expression
            $params = explode(',', $expression);
            $styleName = $params[0];
            $styleScope = trim($params[1]);

            if(strtolower($styleScope) == 'local')
                $php = "<?php echo route('cssAsset', ['styleName' => $styleName]) ?>";
            else if(strtolower($styleScope) == 'external')
                $php = "<?php echo $styleName ?>";

            $html = "<link rel=\"stylesheet\" href=\"$php\" />";

            return $html;
        });


        //URL generation
        /**
         * Returns a URL for a movie or a series
         * 
         * @param movie/series $item Movie or series object
         * @param int $itemId Id of movie or series
         */
        Blade::directive('itemUrl', function ($expression) {
            //Get the variables from the expression
            $params = explode(',', $expression);
            $item = $params[0];
            $itemId = $params[1];
            
            return "<?php
                if(with($item)->getTable() == 'movies')
                    echo route('movieShow', ['id' => $itemId]);
                else if(with($item)->getTable() == 'series')
                    echo route('seriesShow', ['id' => $itemId]); 
            ?>";
        });

        /**
         * Returns a URL for any type of images (theme images, resource images, url images)
         * Theme images are images stored in the theme folder
         * Resource images are those stored using a form
         * URL images are external images provided by an URL
         * 
         * @param string $imageName Name of the image resource 
         * @param string $imageStorage Storage medium of the image resource
         */
        Blade::directive('imageUrl', function ($expression) {
            //Get the variables from the expression
            $params = explode(',', $expression);
            $imageName = $params[0];
            $imageStorage = $params[1];

            if(strtolower($imageStorage) == 'url')
                $php = "<?php echo $imageName; ?>";
            else if(strtolower($imageStorage) == 'theme')
                $php = "<?php echo route('imageAsset', ['imageName' => $imageName]); ?>";
            else
                $php = "<?php echo route('fileResourceImage', ['fileName' => $imageName, 'storage' => $imageStorage]); ?>";
        
            return $php;
        });
    }
}
