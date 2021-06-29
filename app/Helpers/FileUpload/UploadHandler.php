<?php
namespace App\Helpers\FileUpload; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHandler
{
    /**
     * Store the first chunk of the resource
     * @param Request $file request file from the upload form
     * @return string name of the stored file
     */
    public static function storeResource($file)
    {
        $fileName = time() . Str::random(26) . '.' . $file->extension();
        Storage::disk(config('app.storage_disk'))->put($fileName, file_get_contents($file));

        return $fileName;
    }

}