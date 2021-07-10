<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Theme\Theme;
use File;

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
        $path = Theme::getFilePath("js\\$scriptName");

        return response()->file($path);
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
        $path = Theme::getFilePath("css\\$styleName");

        return response()->file(resource_path($path));
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
        $path = Theme::getFilePath("img\\$imageName");

        return response()->file(resource_path($path));
    }
}
