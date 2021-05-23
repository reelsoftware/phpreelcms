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
        $path = "";

        if($storage == 'local')
            $path = base_path().'/storage';
        else if($storage == 's3')
        {
            $client = new S3Client([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ],
                // Set the S3 class to use objects.dreamhost.com/bucket
                // instead of bucket.objects.dreamhost.com
                'use_path_style_endpoint' => true
            ]);
            // Register the stream wrapper from an S3Client object
            $client->registerStreamWrapper();

            $path = 's3://' . env('AWS_BUCKET');
        }
        //Name of the file
        $fileName = '';

        //If it's the first chunk then create a new file
        if($request->videoId == '')
            $fileName = $this->storeResource($request->file('file'));
        else  
        {
            //If the file is already created then append to it the next chunk
            
            //Set file name from previous chunk
            $fileName = $request->videoId;

            //Set different file paths depending on the selected storage option
            if($storage == 'local')
                $filePath = '/app/resources/' . $fileName;
            else
                $filePath = '/resources/' . $fileName;

            $path .= $filePath;

            //Get the files chunks that were already saved
            $savedChunks = fopen($path, 'a');
            
            //Update the saved chunks with the new chunk
            fwrite($savedChunks, file_get_contents($request->file('file')));
            fclose($savedChunks);
        }
        
        return response()->json([
            'videoId' => $fileName,
            'path' => $path
        ]);
    }
}
