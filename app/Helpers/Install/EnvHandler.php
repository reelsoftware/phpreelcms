<?php
namespace App\Helpers\Install; 

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class EnvHandler
{
    /**
    * @var string location of the env file
    */
    private $envFile;

    /**
    * @var array list of the fields present in the env file
    */
    private $envFields;

    /**
    * @var array list of the fields excluded from the installer
    */
    private $excludedEnvFields;

    /**
    * @var array list of the validation rules to be applied to fields
    */
    private $validatedFields;

    public function __construct()
    {
        $this->envFile = base_path('.env');
        $this->envFields = [];
        $this->validatedFields = [];

        $this->excludedEnvFields = $this->getExcludedFields();
        
    }

    /**
     * Set the excluded files from the installer
     *
     * @return array
     */
    private function getExcludedFields()
    {
        //List of all the section names to be excluded
        return ["Theme", "Storage", "Core", "Logs", "Hidden", "Memcached", "Redis", "AWS", "Pusher", "Mix Pusher", "HiddenDb", "Mail", "Stripe"];
    }

    /**
     * Read the env file and save the fields and their category
     *
     */
    public function setEnvFields()
    {
        //Env fields as array
        $envContent = explode("\n", str_replace("\r", "", file_get_contents($this->envFile)));

        $assocArrayValue = [];
        $assocArrayKey = null;

        //Bool if the assocArrayKey is excluded
        $checkInArray = null;

        for($i=0;$i<count($envContent);$i++)
        {
            //Split the fields in keys and values
            $separateFields = explode("=", $envContent[$i]);

            //Check if the field defines a section inside the env
            if($separateFields[0] != "#SECTION")
            {
                if(!$checkInArray)
                {
                    array_push($assocArrayValue, $separateFields[0]);
                }
            }
            else
            {
                if(count($assocArrayValue) != 0 && !$checkInArray)
                {
                    //Add the section value as the key of the assoc array
                    $this->envFields[$assocArrayKey] = array_filter($assocArrayValue);

                    //Empty the assoc values
                    $assocArrayValue = [];
                }

                //Set the assoc array key to the new value
                $assocArrayKey = $separateFields[1];

                //True if the assoc array key is excluded
                $checkInArray = in_array($assocArrayKey, $this->excludedEnvFields);

                //Empty the array if an excluded value is found
                if($checkInArray) 
                {
                    $assocArrayValue = [];
                }
            }
        }

        if(!in_array($assocArrayKey, $this->excludedEnvFields))
        {
            //Add the last value from the env file
            $this->envFields[$assocArrayKey] = array_filter($assocArrayValue);
        }
    }

    /**
     * Return the env fields
     *
     * @return array
     */
    public function getEnvFields()
    {
        return $this->envFields;
    }

    /**
     * Set the validation for the env fields
     *
     * @return array
     */
    public function setValidatedFields()
    {
        //Validate the config file
        $envFields = $this->getEnvFields();
        
        foreach($this->envFields as $section => $envField)
        {
            foreach($envField as $env)
            {
                $this->validatedFields[$env] = 'required';
            }
        }

        //Remove the validation for password
        $this->validatedFields['DB_PASSWORD'] = "";
    }

    /**
     * Return the rules for validation
     *
     * @return array
     */
    public function getValidatedFields()
    {
        return $this->validatedFields;
    }

    /**
     * Writes the env fields to the env file
     * @param Illuminate\Http\Request $request
     */
    public function storeEnvFields(Request $request)
    {
        //Use the validated fields as a base
        $envFieldsValues = $this->validatedFields;

        //Replace the values with the input       
        foreach($envFieldsValues as $key => $value)
        {
            $envFieldsValues[$key] = $request[$key];
        }
            
        $envFieldsValues['APP_KEY'] = 'base64:' . base64_encode(Str::random(32));
        $envFieldsValues['APP_URL'] = URL::to('/');

        //Create the env fields with their values for the env editor
        DotenvEditor::setKeys($envFieldsValues);

        DotenvEditor::save();
    }
}