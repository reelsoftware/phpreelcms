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
        $filenames = glob(app_path('Helpers/Theme/Components/*.php'));

        if ($filenames !== false && is_iterable($filenames)) 
            foreach ($filenames as $filename) 
                require_once $filename;
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
         * Returns the element that will contain all the credit card information
         * 
         */
        Blade::directive('card', function () {
            return '<?php echo ("<div id=\"card\"></div>")?>';
        });

        /**
         * Displays the credit card errors
         * 
         */
        Blade::directive('cardError', function () {
            return '<?php echo ("<div id=\"cardError\" role=\"alert\"></div>")?>';
        });

        /**
         * Form containing the card holder name
         * 
         */
        Blade::directive('cardName', function () {
            return '<?php echo ("
                <input id=\"cardName\" name=\"cardHolderName\" placeholder=\"Card holder name\" required>
            ")?>';
        });

        /**
         * Button that submits the information
         * @param string $buttonText text to display inside the button
         */
        Blade::directive('cardSubmit', function ($buttonText) {
            //Remove quotes
            $buttonText = substr($buttonText, 1, strlen($buttonText)-2);
           // dd($buttonText);
            return '<?php echo ("
                <input id=\"cardSubmit\" type=\"submit\" class=\"btn ne-btn pay\" value=\"' . $buttonText . '\">
            ")?>';
        });

        /**
         * Hidden inputs to make payments work
         * 
         * @param string $imageName Name of the plan
         */
        Blade::directive('cardInfo', function ($name) {
            return '<?php echo ("
                <input type=\"hidden\" name=\"payment_method\" class=\"payment-method\">
                <input type=\"hidden\" value=\"$name\" name=\"plan\">
            ")?>';
        });
    }
}
