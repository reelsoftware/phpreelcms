<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return response()->view(env('theme') . '.js.' . $scriptName)
            ->header('Content-Type', 'application/javascript');
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
        return response()->view(env('theme') . '.css.' . $styleName)
            ->header('Content-Type', 'application/javascript');
    }
}
