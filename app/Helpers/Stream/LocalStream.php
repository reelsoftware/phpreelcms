<?php
namespace App\Helpers\Stream; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Image;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Video;
use Exception;
use Arr;


class LocalStream extends BaseStream
{
    /**
     * Stream file to client.
     * @throws Exception
     */
    protected function stream(): StreamedResponse
    {
        // Open a stream in read-only mode
        if (!($stream = fopen(storage_path("app/resources/$this->filePath"), 'rb', false))) 
        {
            throw new Exception('Could not open stream for reading export [' . $this->filePath . ']');
        }
       
        if (isset($this->start) && $this->start > 0) 
        {
            fseek($stream, $this->start, SEEK_SET);
        }

        $remainingBytes = $this->length ?? $this->size;

        //Chunk size in bytes
        $chunkSize = 100;

        //stream(Closure $callback, int $status = 200, array $headers = [])
        $video = response()->stream(
            function () use ($stream, $remainingBytes, $chunkSize) 
            {
                while (!feof($stream) && $remainingBytes > 0) 
                {
                    $toGrab = min($chunkSize, $remainingBytes);
                    echo fread($stream, $toGrab);
                    $remainingBytes -= $toGrab;
                    flush();
                }
                fclose($stream);
            },
            ($this->isRange ? 206 : 200),
            $this->returnHeaders
        );

        return $video;
    }
}