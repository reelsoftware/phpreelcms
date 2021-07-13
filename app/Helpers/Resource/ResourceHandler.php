<?php
namespace App\Helpers\Resource; 

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;
use App\Models\Image;

class ResourceHandler
{
    /**
     * Get all the available local storage mediums (local, s3)
     * 
     * @return array
     */
    public static function getLocalStorage(): array
    {
        return ['local', 's3'];
    }

    /**
     * Get all the available external storage mediums (local, s3)
     * 
     * @return array
     */
    public static function getExternalStorage(): array
    {
        return ['youtube', 'vimeo'];
    }

    /**
     * Return true if video is premium, false if not, null if it doesn't exist
     *
     * @return bool
     */
    public static function checkPremium($storage, $fileName): bool
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
     * 
     * @return int id of the new row from the image table
     */
    public static function addImage($fileName): int
    {
        $image = new Image();
        $image->name = $fileName;
        $image->storage = config('app.storage_disk');
        $image->save();

        return $image->id;
    }

    /**
     * Add a video resource to the video database
     *
     * @param string $fileName name of the
     * @param string $storage storage medium of the external file (youtube, vimeo)
     * @param int $premium by default every video is saved as premium (0=non premium, 1=premium)
     * @param int $auth by default every video requires auth (0=no auth required, 1=requires auth)
     * 
     * @return int id of the new row from the video table
     */
    public static function addVideo($fileName, $storage, $premium = 1, $auth = 1): int
    {
        $video = new Video();
        $video->name = $fileName;
        $video->storage = $storage;
        $video->premium = $premium;
        $video->auth = $auth;

        $video->save();

        return $video->id;
    }

    /**
     * Delete a specific resource (video, image)
     *
     * @param string $fileName name of the
     * @param string $storage storage medium of the external file (youtube, vimeo)
     * 
     * @return Illuminate\Support\Facades\Storage
     */
    public static function delete($fileName, $storage)
    {
        if (Storage::disk($storage)->exists($fileName)) 
            return Storage::disk($storage)->delete($fileName);
    }

    /**
     * Update a video resource
     *
     * @param string $fileName name of the video file
     * @param string $videoId id of the database row that contains that specific video
     * @param string $storage storage medium 
     * @param int $premium by default every video is saved as premium (0=non premium, 1=premium)
     * @param int $auth by default every video requires auth (0=no auth required, 1=requires auth)
     * 
     */
    public static function updateVideo($fileName, $videoId, $storage, $premium = 1, $auth = 1)
    {
        //Get video name and storage location for video
        $video = Video::where('id', '=', $videoId)->first();

        //Delete the old video if available
        if(in_array($video['storage'], ResourceHandler::getLocalStorage())) 
            ResourceHandler::delete($video->name, $video->storage);

        //Update the video
        $video->name = $fileName;
        $video->storage = $storage;
        $video->premium = $premium;
        $video->auth = $auth;

        $video->save();
    }

    /**
     * Update a image resource
     *
     * @param string $fileName name of the image file
     * @param string $imageId id of the database row that contains that specific image
     * @param string $storage storage medium 
     * 
     */
    public static function updateImage($fileName, $imageId, $storage)
    {
        //Get image name and storage location for image
        $image = Image::where('id', '=', $imageId)->first();

        //Delete old image
        ResourceHandler::delete($image->name, $image->storage);

        //Store the new image
        $image->name = $fileName;
        $image->storage = $storage;

        $image->save();
    }

    /**
     * Return the values stored in the premium and auth fields of a video
     *
     * @param string $fileName name of the video file
     * 
     * @return array
     */
    public static function getAccessAvailabilityVideo(string $fileName): array
    {
        $video = Video::where('name', '=', $fileName)
            ->first(['premium', 'auth']);

        return $video->toArray();
    }
}