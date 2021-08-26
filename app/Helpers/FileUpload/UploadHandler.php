<?php
namespace App\Helpers\FileUpload; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHandler
{
    /**
     * Store the first chunk of the resource
     * 
     * @param Request $file request file from the upload form
     * @param String $storage medium used for the file
     * @param String $path to the directory where the file should be stored, empty to store in root
     * 
     * @return string name of the stored file
     */
    public static function storeResource($file, $storage, $path = "")
    {
        $fileName = time() . Str::random(26) . '.' . $file->extension();

        Storage::disk($storage)->put($path . $fileName, file_get_contents($file));

        return $fileName;
    }
}