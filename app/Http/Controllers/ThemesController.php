<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use File;

class ThemesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //Get all the themes available in themes folder
        $directories = array_map('basename', File::directories(resource_path('themes')));

        return view('themes.index', [
            'directories' => $directories
        ]);
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

        return redirect()->route('themeEdit');
    }
}
