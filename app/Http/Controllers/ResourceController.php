<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\FileUpload\StorageMethods\StorageContext;
use App\Helpers\FileUpload\StorageMethods\LocalStrategy;
use App\Helpers\FileUpload\StorageMethods\S3Strategy;
use App\Helpers\Resource\StreamResource;
use Storage;


class ResourceController extends Controller
{
    //Return image files
    public function imageFile($storage, $fileName)
    {
        return StreamResource::streamFile($storage, $fileName);
    }

    //Return video files
    public function file($storage, $fileName)
    {
        return StreamResource::streamFile($storage, $fileName);
    }

    //Store resource
    public function storeAPI(Request $request)
    {
    	$storage = config('app.storage_disk');
    	$storageContext = new StorageContext();

        //Update the strategy based on storage
    	if($storage == 'local')
    		$storageContext->setStorageStrategy(new LocalStrategy());
        else if($storage == 's3')
    		$storageContext->setStorageStrategy(new S3Strategy());

        //Get the JSON response from previous call
    	$response = $storageContext->execute($request);

        //Send the JSON response to the next call
    	return response()->json($response);
        
    }
}
