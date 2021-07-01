<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ContentManager
{
    /**
    * @var array names of the fields added by the user
    */
    private $fieldNames;

    /**
    * @var array assoc array of the fields submited by the user 
    */
    private $fieldValues;

    /**
     * @param Illuminate\Http\Request $request
     * 
     * @return array 
     */
    public function __construct(Request $request)
    {
        $this->fieldNames = [];
        $this->fieldValues = [];
        $this->setRequestFields($request);  
    }

    public function getFieldNames()
    {
        return $this->fieldNames;
    }

    public function getfieldValues()
    {
        return $this->fieldValues;
    }

    /**
     * Get the name of the fields added by the user
     */
    private function setRequestFields(Request $request)
    {   
        foreach ($request->except('_token') as $field => $value)
        {
            //Check to see if the request has a value assigned to it
            if($value != '')
            {
                array_push($this->fieldNames, $field);
                $this->fieldValues[$field] = $value;
            }
        }
    }

    /**
     * General validation data for any type of request
     *
     * @param string $field name of the field that we requested validation for
     * 
     * @return string return the requested validation rule or null if it doesn't exist
     */
    private function getValidationData($field)
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
            'trailerId' => 'required|max:45'
        ];

        if (isset($validationData[$field]))
            return $validationData[$field];
        else 
            return null;
    }

    /**
     * Get validation array based on the request fields
     * 
     * @return array validation array used to validate the request
     */
    public function getValidationArray()
    {   
        $validationArray = [];

        foreach ($this->fieldNames as $field)
            $validationArray[$field] = $this->getValidationData($field);

        return $validationArray; 
    }

    /**
     * Get validation array based on the request fields
     *
     * @param Illuminate\Database\Eloquent\Model $content define the type of content to be added by defining the model
     * 
     * @return array validation array used to validate the request
     */
    public function storeContent(Model $content)
    {
        foreach ($this->fieldValues as $field => $value)
        {
            $content[$field] = $value;
        }
    }
}