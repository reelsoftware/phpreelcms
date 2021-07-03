<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Helpers\Resource\ResourceHandler;

class MovieHelper
{
    public static function timeToSeconds(string $time): int
    {
        $d = explode(':', $time);
        return (intval($d[0]) * 3600) + (intval($d[1]) * 60);
    }
}