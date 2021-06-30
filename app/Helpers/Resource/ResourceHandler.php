<?php
namespace App\Helpers\Resource; 

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\Video;

class ResourceHandler
{
    /**
     * Return true if video is premium, false if not, null if it doesn't exist
     *
     * @return bool
     */
    public static function checkPremium($storage, $fileName)
    {
        //Check if the video files is premium
        $file = Video::where([
            ['name', '=', $fileName], 
            ['storage', '=', $storage], 
        ])->first('premium');

        if($file == null)
            return null;
        else
            if($file->premium == 1)
                return true;
            else 
                return false;
    }

    /**
     * Add a image resource to the database
     *
     * @param string $fileName name of the image
     * @return bool
     */
    public static function addImage($fileName)
    {
        $image = new Image();
        $image->name = $fileName;
        $image->storage = config('app.storage_disk');
        $image->save();

        return $image->id;
    }

    /**
     * Add a external video resource (YouTube, Vimeo) to the video database
     *
     * @param string $videoId id of the external file
     * @param string $storage storage medium of the external file (youtube, vimeo)
     * 
     * @return int id of the new row from the video table
     */
    public static function addVideoExternal($videoId, $storage)
    {
        $video = new Video();
        $video->name = $videoId;
        $video->storage = $storage;
        $video->save();

        return $video->id;
    }

    /**
     * Add a video resource to the video database
     *
     * @param string $fileName name of the
     * @param string $storage storage medium of the external file (youtube, vimeo)
     * @param int $premium by default every video is saved as premium (0=non premium, 1=premium)
     * 
     * @return int id of the new row from the video table
     */
    public static function addVideo($fileName, $premium=1)
    {
        $video = new Video();
        $video->name = $fileName;
        $video->storage = config('app.storage_disk');
        $video->premium = $premium;

        $video->save();

        return $video->id;
    }
}