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
     * 
     * @return string name of the stored file
     */
    public static function storeResource($file, $storage)
    {
        $fileName = time() . Str::random(26) . '.' . $file->extension();
        Storage::disk($storage)->put("/resources/$fileName", file_get_contents($file));

        return $fileName;
    }
}