<?php
namespace App\Helpers\Video; 

use Owenoj\LaravelGetId3\GetId3;

class VideoProperties
{
    /**
     * Returns the length of an existing video
     *
     * @param string $storage where the video was stored
     * @param string $videoPath to the video in that storage system
     * 
     * @return int
     */
    public static function lengthSeconds($storage, $videoPath): int
    {  
        $videoInfo = GetId3::fromDiskAndPath($storage, $videoPath);

        return floor($videoInfo->getPlaytimeSeconds());
    }
}