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

        /**
         * Checks to see if a particular item corresponds to the movies table
         * 
         * @param string $expression Storage medium used for the resource
         */
        Blade::if('IsMovie', function ($expression) {
            return $expression === "movies";
        });

        /**
         * Checks to see if a particular item corresponds to the series table
         * 
         * @param string $expression Storage medium used for the resource
         */
        Blade::if('IsSeries', function ($expression) {
            return $expression === "series";
        });
    }
}
