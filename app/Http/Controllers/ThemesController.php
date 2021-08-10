<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Helpers\Theme\Theme;
use Illuminate\Support\Facades\Log;
use File;
use Zip;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fileId' => 'required',
        ]);

        $themeZipPath = resource_path("themes/$request->fileId");

        //Move the zip archive from resources to themes
    	File::move(storage_path("app/resources/$request->fileId"), $themeZipPath);

        if(Zip::check($themeZipPath))
        {
            $zip = Zip::open($themeZipPath);
            $zip->extract(resource_path("themes"));
            $zip->close();
        }
      
        File::delete($themeZipPath);
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

        //Copy the language files from theme folder to resources/lang 
        Theme::syncLang();

        return redirect()->route('themeIndex');
    }

    public function destroy(Request $request)
    {
        Theme::deleteTheme($request->theme);
      
        return redirect()->route('themeIndex');
    }
}
