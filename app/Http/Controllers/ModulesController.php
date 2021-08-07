<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Helpers\Module\ModuleHandler;
use Illuminate\Support\Facades\Log;
use File;
use Zip;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Get all the plugins available in themes folder
        $modules = ModuleHandler::getModulesDetails(ModuleHandler::getModules());
        
        return view('modules.index', [
            'modules' => $modules
        ]);
    }

    /**
     * Display the cover of a particular theme
     *
     * @param string $theme name of the theme
     * 
     * @return \Illuminate\Http\Response
     */
    public function cover($module)
    {
        return response()->file(base_path('Modules/'. $module . '/cover.jpg'));
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
        $request->validate([
            'fileId' => 'required',
        ]);

        $moduleZipPath = base_path("Modules/$request->fileId");

        //Move the zip archive from resources to themes
    	File::move(storage_path("app/resources/$request->fileId"), $moduleZipPath);

        if(Zip::check($moduleZipPath))
        {
            $zip = Zip::open($moduleZipPath);
            $zip->extract(base_path("Modules"));
            $zip->close();
        }
      
        File::delete($moduleZipPath);
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
