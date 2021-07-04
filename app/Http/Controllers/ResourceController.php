<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\StoreResourceTrait;
use App\Http\Traits\RetreiveResourceTrait;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Carbon\Carbon;
use App\Http\Responses\S3FileStream as S3FileStream;
use App\Helpers\FileUpload\StorageMethods\StorageContext;
use App\Helpers\FileUpload\StorageMethods\LocalStrategy;
use App\Helpers\FileUpload\StorageMethods\S3Strategy;
use App\Helpers\Resource\StreamResource;
use Storage;


class ResourceController extends Controller
{
    use StoreResourceTrait, RetreiveResourceTrait;

    //Return image files
    public function imageFile($storage, $fileName)
    {
        //If storage disk is set to s3 then return files from S3 Bucket
        if($storage == 's3')
        {
            if (Storage::disk($storage)->exists('resources/' . $fileName)) 
            {
                $this->setter('resources/' . $fileName, $storage, $fileName);

                $filestream = $this->output();

                return $filestream;
            }
            else
                return abort(404);
        }
        else if($storage == 'local')
        {
            $exists = Storage::disk('local')->exists($fileName);

            if($exists)
                return response()->file(storage_path('app/resources/' . $fileName));
            else 
                return abort(404);
        }
    }

    //Return video files
    public function file($storage, $fileName)
    {
        return StreamResource::streamVideo($storage, $fileName);
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
