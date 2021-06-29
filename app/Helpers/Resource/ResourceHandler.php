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
}