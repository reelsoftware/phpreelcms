<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Helpers\Module\ModuleHandler;
use Illuminate\Support\Facades\Log;
use File;
use Zip;
use Module;

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
     * Works as a toggle, enable or disable a particular module
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $module = Module::find($request->theme);

        if(Module::collections()->has($request->theme))
            $module->disable();
        else
            $module->enable();

        return redirect()->route('moduleIndex');
    }

    public function destroy(Request $request)
    {
        $module = Module::find($request->theme);
        $module->delete();
      
        return redirect()->route('moduleIndex');
    }
}
