<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Helpers\Theme\Theme;


class ThemesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all the themes available in themes folder
        $themes = Theme::getThemesDetails(Theme::getBaseThemes());
       
        return view('themes.index', [
            'themes' => $themes
        ]);
    }

    /**
     * Display the cover of a particular theme
     *
     * @param string $theme name of the theme
     * 
     * @return \Illuminate\Http\Response
     */
    public function cover($theme)
    {
        return response()->file(resource_path('themes/'. $theme . '/cover.jpg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        //Update .env file
        DotenvEditor::setKeys([
            'THEME' => $request->theme,
        ]);

        DotenvEditor::save();

        //Generate child theme if it doesn't exist
        Theme::generateChildTheme($request->theme);

        return redirect()->route('themeIndex');
    }

    public function destroy(Request $request)
    {
        Theme::deleteTheme($request->theme);
      
        return redirect()->route('themeIndex');
    }
}
