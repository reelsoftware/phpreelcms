<?php

namespace App\Http\Controllers;

use App\Helpers\Theme\Theme;
use File;
use Response;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string scriptName The name of the script to be returned
     * 
     * @return \Illuminate\Http\Response
     */
    public function javascript($scriptName)
    {
        $path = Theme::getFilePath("js/$scriptName");

        $headers = [
            'Content-Type' => 'text/javascript',
        ];

        return response()->file($path, $headers);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string styleName The name of the css style to be returned
     * 
     * @return \Illuminate\Http\Response
     */
    public function css($styleName)
    {
        $path = Theme::getFilePath("css/$styleName");

        $headers = [
            'Content-Type' => 'text/css',
        ];

        return response()->file($path, $headers);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string imageName The name of the theme image to be returned
     * 
     * @return \Illuminate\Http\Response
     */
    public function image($imageName)
    {
        $path = Theme::getFilePath("img/$imageName");

        return response()->file(resource_path($path));
    }
}
