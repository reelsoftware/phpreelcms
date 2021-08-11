<?php
namespace App\Helpers\Stream; 

use Symfony\Component\HttpFoundation\StreamedResponse;

class S3Stream extends BaseStream
{
    /**
     * Stream file to client.
     * @throws Exception
     * @return StreamedResponse
     */
    protected function stream(): StreamedResponse
    {
        $this->adapter->getClient()->registerStreamWrapper();
        // Create a stream context to allow seeking
        $context = stream_context_create([
            's3' => [
                'seekable' => true,
            ],
        ]);
        // Open a stream in read-only mode
        if (!($stream = fopen("s3://{$this->adapter->getBucket()}/{$this->filePath}", 'rb', false, $context))) 
            throw new Exception('Could not open stream for reading export [' . $this->filePath . ']');
       
        if (isset($this->start) && $this->start > 0) 
            fseek($stream, $this->start, SEEK_SET);

        $remainingBytes = $this->length ?? $this->size;

        //Chunk size in bytes
        $chunkSize = 100;

        //stream(Closure $callback, int $status = 200, array $headers = [])
        $video = response()->stream(
            function () use ($stream, $remainingBytes, $chunkSize) {
                while (!feof($stream) && $remainingBytes > 0) {
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