<?php
namespace App\Helpers; 

class Helper
{
    public static function timeToSeconds(string $time): int
    {
        $d = explode(':', $time);
        return (intval($d[0]) * 3600) + (intval($d[1]) * 60);
    }
}