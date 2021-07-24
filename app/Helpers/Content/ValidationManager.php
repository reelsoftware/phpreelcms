<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ValidationManager
{

    /**
     * General validation data for any type of request
     *
     * @param string $field name of the field that we requested validation for
     * 
     * @return string return the requested validation rule or null if it doesn't exist
     */
    public static function getValidationData($field)
    {
        $validationData = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'year' => 'required',
            'rating' => 'required|max:25',
            'length' => 'required',
            'cast' => 'required|max:500',
            'genre' => 'required|max:500',
            'thumbnail' => 'required|max:45',
            'public' => 'required|boolean',
            'video' => 'required|max:45',
            'videoId' => 'required|max:45',
            'trailer' => 'required|max:45',
            'trailerId' => 'required|max:45',
            'platformVideo' => 'required',
            'platformTrailer' => 'required',
            'access' => 'required',
            'availability' => 'required',
            'series_id' => 'required',
            'season_id' => 'required'
        ];

        if (isset($validationData[$field]))
            return $validationData[$field];
        else 
            return null;
    }

    /**
     * Get validation array based on the request fields
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return array validation array used to validate the request
     */
    public static function getValidationArray($request)
    {   
        $fieldNames = [];

        foreach ($request->except('_token') as $field => $value)
        {
            //Check to see if the request has a value assigned to it
            if($value != '')
                array_push($fieldNames, $field);
        }
        
        $validationArray = [];

        foreach ($fieldNames as $field)
            $validationArray[$field] = ValidationManager::getValidationData($field);

        return $validationArray; 
    }
}