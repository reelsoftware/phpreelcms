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
        $path = '';

        if(Theme::existsChildView($scriptName))
            $path = 'themes/'. 'child-' . config('app.theme') . '/js//' . $scriptName;
        else
            $path = 'themes/' . config('app.theme') . '/js//' . $scriptName;

        return response()->file(resource_path($path));
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
        $path = '';

        if(Theme::existsChildView($styleName))
            $path = 'themes/'. 'child-' . config('app.theme') . '/css//' . $styleName;
        else
            $path = 'themes/' . config('app.theme') . '/css//' . $styleName;

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
        $path = '';

        if(Theme::existsChildView($imageName))
            $path = 'themes/'. 'child-' . config('app.theme') . '/img//' . $imageName;
        else
            $path = 'themes/' . config('app.theme') . '/img//' . $imageName;

        return response()->file(resource_path($path));
    }
}
