<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\FileUpload\StorageMethods\StorageContext;
use App\Helpers\FileUpload\StorageMethods\LocalStrategy;
use App\Helpers\FileUpload\StorageMethods\S3Strategy;
use App\Helpers\Resource\StreamResource;
use Illuminate\Support\Facades\Log;
use App\Models\Video;
use Storage;
use Auth;

class ResourceController extends Controller
{
    //Return image files
    public function imageFile($storage, $fileName)
    {
        return StreamResource::streamFile($storage, $fileName);
    }

    //Return video files
    public function videoFile(Request $request, $storage, $fileName)
    {
        return StreamResource::streamFile($storage, $fileName);
    }

    /**
     * Store a particular resource
     *
     * @var string $storage optional parameter to specify the storage medium to be used, if not specified it will use the default storage from the env
     * 
     * @return \Illuminate\Http\Response
     */
    public function storeAPI(Request $request, $storage = null)
    {
        if($storage == null)
    	    $storageMedium = config('app.storage_disk');
        else
            $storageMedium = $storage;
        
    	$storageContext = new StorageContext();

        //Update the strategy based on storage
    	if($storageMedium == 'local')
    		$storageContext->setStorageStrategy(new LocalStrategy());
        else if($storageMedium == 's3')
    		$storageContext->setStorageStrategy(new S3Strategy());

        //Get the JSON response from previous call
    	$response = $storageContext->execute($request);

        //Send the JSON response to the next call
    	return response()->json($response);
    }
}
