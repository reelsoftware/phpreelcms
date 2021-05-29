<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return response()->file(resource_path('themes/'. env('theme') . '/js/' . $scriptName));
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
        return response()->file(resource_path('themes/'. env('theme') . '/css/' . $styleName));
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
        return response()->file(resource_path('themes/'. env('theme') . '/img/' . $imageName));
    }
}
