<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;
use Auth;
use App\Http\Traits\StoreResourceTrait;
use App\Http\Traits\RetreiveResourceTrait;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Carbon\Carbon;
use App\Http\Responses\S3FileStream as S3FileStream;
use App\Helpers\FileUpload\StorageMethods\StorageContext;
use App\Helpers\FileUpload\StorageMethods\LocalStrategy;


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
        //Check if the video files is premium
        $file = Video::where([
            ['name', '=', $fileName], 
            ['storage', '=', $storage], 
        ])
        ->first('premium');

        if ($file != null)
            $premium = $file->premium;
        else
            $premium = 0;

        /**
         * pass = check variable to decide if the video passes to the user
         */

        $pass = false;
        //If the video is either free or a trailer
        if($premium == 0)
            $pass = true;
        else
        {
            //If it's not free then check the subscription
            $user = Auth::user();

            if($user != null)
            {
                $defaultSubscription = 'default';
                $subscribed = $user->subscribed($defaultSubscription);

                if($subscribed == 1)
                    $pass = true;
            }
        }

        if(Auth::check())
            $auth = true;
        else
            $auth = false;

        if($auth == true)
            $user = Auth::user()->first('roles');

        //If the video is free or user is subscribed
        if($premium == 0 || ($premium == 1 && $pass == true) || ($auth == true && $user->roles == 'admin'))
        {
            //If storage disk is set to s3 then return files from S3 Bucket
            if($storage == 's3')
            {
                if (Storage::disk($storage)->exists('resources/' . $fileName)) 
                {
                    $url = Storage::disk($storage)->temporaryUrl(
                        'resources/' . $fileName, now()->addMinutes(5)
                    );

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
        else
        {
            return abort(404);
        }

        $this->setter('resources/' . $fileName, $storage, $fileName);

        $filestream = $this->output();

        return $filestream;

    }

    //Store resource
    public function storeAPI(Request $request)
    {
    	$storage = config('app.storage_disk');
    	$storageContext = new StorageContext();

    	if($storage == 'local')
    		$storageContext->setStorageStrategy(new LocalStrategy());

    	$v = $storageContext->execute($request);

    	return response()->json($v);
        
    }
}
