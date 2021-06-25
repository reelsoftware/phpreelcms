<?php
namespace App\Helpers\Install; 

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

    public function __construct()
    {
        $this->envFile = base_path('.env');
        $this->envFields = [];
        $this->excludedEnvFields = $this->setExcludedFields();
    }

    /**
     * Set the excluded files from the installer
     *
     * @return array
     */
    private function setExcludedFields()
    {
        //List of all the section names to be excluded
        return ["Theme", "Storage"];
    }

    public function setEnvFields()
    {
        //Env fields as array
        $envContent = explode("\r\n", file_get_contents($this->envFile));

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
                array_push($assocArrayValue, $separateFields[0]);
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
                    $assocArrayValue = [];

            }
        }

        if(!in_array($assocArrayKey, $this->excludedEnvFields))
        {
            //Add the last value from the env file
            $this->envFields[$assocArrayKey] = array_filter($assocArrayValue);
        }
    }

    public function getEnvFields()
    {
        return $this->envFields;
    }
}