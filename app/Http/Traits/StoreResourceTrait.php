<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\Video;

trait StoreResourceTrait {

    //Add a new resource 
    //$file = $request->file('name');
    protected function storeResource($file)
    {
        $fileName = time() . Str::random(26) . '.' . $file->extension();

        if(config('app.storage_disk') == 's3')
            $filePath = 'resources/' . $fileName;
        else 
            $filePath = $fileName;
            
        Storage::disk(config('app.storage_disk'))->put($filePath, file_get_contents($file));

        return $fileName;
    }

    //Append to a existing resource 
    //$fileName = name of the existing file that you want to append to
    //$file = $request->file('name');
    protected function appendResource($fileName, $file)
    {
        $filePath = $fileName;
        $storage = Storage::disk(config('app.storage_disk'))->append($filePath, file_get_contents($file));

        $filePath = null;
        $storage = null;
    }

    //Delete a new resource 
    //$fileName = name of the file to be deleted
    protected function deleteResource($fileName, $storage)
    {
        if (Storage::disk($storage)->exists($fileName)) 
        {
            return Storage::disk($storage)->delete($fileName);
        }
    }

    //Update a video resource
    //$requestFile = request data from input
    //$fileName = video name
    //$storage = used storage medium
    //$premium = by default every video is saved as premium (0=non premium, 1=premium)
    protected function updateVideoResource($fileName, $videoId, $storage, $premium=1)
    {
        //Get video name and storage location for video
        $video = Video::where('id', '=', $videoId)->first();

        //Check the storage medium
        if($storage == 'vimeo' || $storage == 'youtube')
        {
            $video->name = $fileName;
            $video->storage = $storage;
            $video->premium = $premium;
            $video->save();
        }
        else
        {
            if($video['storage'] == 'local' || $video['storage'] == 's3')
            {
                //Delete old video
                $this->deleteResource($video->name, $video->storage);
            }
            
            //Store the new video
            $video->name = $fileName;
            $video->storage = $storage;
            $video->premium = $premium;
            $video->save();
        }
    }

    //Update a image resource
    //$requestFile = request data from input
    //$fileName = video name
    //$storage = used storage medium
    protected function updateImageResource($fileName, $imageId, $storage)
    {
        //Get image name and storage location for image
        $image = Image::where('id', '=', $imageId)->first();

        //Delete old image
        $this->deleteResource($image->name, $image->storage);

        //Store the new image
        $image->name = $fileName;
        $image->storage = $storage;

        $image->save();
    }

}