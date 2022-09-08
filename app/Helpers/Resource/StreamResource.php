<?php
namespace App\Helpers\Resource; 

use App\Helpers\Stream\LocalStream;
use App\Helpers\Stream\S3Stream;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamResource
{
    /**
     * Stream files from different streams of data
     *
     * @param string $storage Name of the storage medium (local, s3)
     * @param string $fileName Name of the file to be streamed
     * 
     * @return Symfony\Component\HttpFoundation\StreamedResponse
     */
    public static function streamFile($storage, $fileName): StreamedResponse
    {
        $stream = null;

        if($storage == 's3')
        {
            $stream = new S3Stream();
        }
        else if($storage == 'local')
        {
            $stream = new LocalStream();
        }
        else
        {
            abort(404);
        }

        $stream->setter($fileName, $storage, $fileName);
        $filestream = $stream->output();

        return $filestream;
    }
}