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
            return (($expression === "html5") || ($expression === "s3"));
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
         * Returns a script tag with the requested local script
         * 
         * @param string $expression Name of the script file saved in the "js" directory of the theme
         */
        Blade::directive('scriptJsLocal', function ($expression) {
            $php = "<?php 
                echo route('jsAsset', ['scriptName' => $expression])
            ?>";
            $html = "<script type=\"text/javascript\" src=\"$php\"></script>";

            return $html;
        });

        /**
         * Returns a script tag with the requested local script
         * 
         * @param string $expression URL of the script file (this can be a CDN)
         */
        Blade::directive('scriptJsExternal', function ($expression) {
            $php = "<?php echo $expression ?>";
            $html = "<script src=\"$php\"></script>";

            return $html;
        });

        //CSS assets
        /**
         * Returns a css file link with the requested local script
         * 
         * @param string $expression Name of the css file saved in the "css" directory of the theme
         */
        Blade::directive('styleCssLocal', function ($expression) {
            $php = "<?php 
                echo route('cssAsset', ['styleName' => $expression])
            ?>";
            $html = "<link rel=\"stylesheet\" href=\"$php\" />";

            return $html;
        });

        /**
         * Returns a css file link with the requested local script
         * 
         * @param string $expression URL of the css file (this can be a CDN)
         */
        Blade::directive('styleCssExternal', function ($expression) {
            $php = "<?php echo $expression ?>";
            $html = "<link rel=\"stylesheet\" href=\"$php\" />";

            return $html;
        });
    }
}
