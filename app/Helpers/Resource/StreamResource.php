<?php
namespace App\Helpers\Resource; 

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Helpers\User\UserHandler;
use Auth;
use Illuminate\Support\Facades\Storage;


class StreamResource
{
    /**
     * @var string Name of the storage medium (local, s3)
     */
    private $storage;

    /**
     * @var string Name of the file to be streamed (local, s3)
     */
    private $fileName;

    /**
     * @var int 1 if video is premium, 0 if not, null if it doesn't exist
     */
    private $premium;

    public function __construct($storage, $fileName)
    {
        $this->storage = $storage;
        $this->fileName = $fileName;
    }

    public static function streamVideo($storage, $fileName)
    {
        //Check if the video files is premium
        $premium = ResourceHandler::checkPremium($storage, $fileName);

        $subscribed = UserHandler::checkSubscription();

        $userRole =  UserHandler::getUserRole();

        //If the video is free or user is subscribed
        if($premium == 0 || ($premium == 1 && $subscribed == true) || (Auth::check() && $userRole == 'admin'))
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
}