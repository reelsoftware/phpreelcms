<?php
namespace App\Helpers\Resource; 


class AssetHandler
{
    /**
     * Return the content types used in the http header based on the image extension
     *
     * @param string $path to the image
     */
    public static function getImageContentType($path)
    {
        $extension = ltrim(strchr($path, '.'), '.');

        if(in_array($extension, ['jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp']))
        {
            return 'image/jpeg';
        }
        else if($extension == 'png')
        {
            return 'image/png';
        }
        else if($extension == 'svg')
        {
            return 'image/svg+xml';
        }
        else if($extension == 'gif')
        {
            return 'image/gif';
        }
        else if($extension == 'webp')
        {
            return 'image/webp';
        }
        else if($extension == 'apng')
        {
            return 'image/apng';
        }
        else if($extension == 'avif')
        {
            return 'image/avif';
        }
        else 
        {
            return null;
        }
    }
}