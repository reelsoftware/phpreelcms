<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Lang;
use File;
use App\Models\Translation;
use App\Helpers\Translation\TranslationHandler;
use App;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $translations = TranslationHandler::getTranslationsSimplePaginate(10);

        return view('translation.index', [
            'translations' => $translations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languageFile = TranslationHandler::getDefaultTranslationFileContent();
        
        return view('translation.create', [
            'languageFile' => $languageFile,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate( [
            'language' => 'required|unique:translations|max:25',
        ]);

        //Register the translation to the database
        $translation = new Translation();
        $translation->language = $request->language;
        $translation->save();

        //Get the default language file from resources
        $languageFile = TranslationHandler::getDefaultTranslationFileContent();
        
        //Add translations from the form to the JSON
        foreach($languageFile as $enKey => $translateValue)
        {
            $key = str_replace(' ', '_', $enKey);

            //Check if there is any translation provided by the user
            if($request[$key] != null)
            {
                $languageFile[$enKey] = $request[$key];
            }
            else
            {
                $languageFile[$enKey] = '';
            }
        }

        //Save the translation file as a json file
        TranslationHandler::saveTranslationFile($request->language, $languageFile);
        
        return redirect(route('translationDashboard'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get the translation name from database
        $translation = Translation::find($id);

        //Get the default language file from resources
        $defaultFile = TranslationHandler::getDefaultTranslationFileContent();

        //Get the json language file from resources
        $languageFile = TranslationHandler::getTranslationFileContent($translation['language']);

        return view('translation.edit', [
            'languageFile' => $languageFile,
            'defaultFile' => $defaultFile,
            'translation' => $translation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate( [
            'language' => [
                'required',
                'max:25',
                Rule::unique('translations', 'language')->ignore($id)
            ]
        ]);

        //Get the translation from database
        $translation = Translation::find($id);

        //Get the json language file from resources
        $defaultFile = TranslationHandler::getDefaultTranslationFileContent();

        //Delete the old json file
        TranslationHandler::deleteTranslationFile($translation['language']);

        //Loop counter
        $i = 0;

        //Update translations from the JSON
        foreach($defaultFile as $enKey => $translateValue)
        {
            //Check if there is any translation provided by the user
            if($request[strval($i)] != null)
            {
                $defaultFile[$enKey] = $request[strval($i)];
            }
            else
            {
                $defaultFile[$enKey] = '';
            }

            $i++;
        }

        //Save the translation file as a json file
        TranslationHandler::saveTranslationFile($request->language, $defaultFile);

        //Update the translation name from database
        $translation->language = $request->language;
        $translation->save();

        return redirect(route('translationEdit', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete the language from database
        $language = Translation::find($id);

        if($language != null)
        {
            $language->delete();
        }

        TranslationHandler::deleteTranslationFile($language['language']);

        return redirect()->route('translationDashboard');
    }
}
