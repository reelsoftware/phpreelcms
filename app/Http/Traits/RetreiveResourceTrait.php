<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Image;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Video;

trait RetreiveResourceTrait 
{
    /**
     * @var \League\Flysystem\AwsS3v3\AwsS3Adapter
     */
    private $adapter;

    /**
     * Name of adapter
     *
     * @var string
     */
    private $adapterName;

    /**
     * Storage disk
     *
     * @var FilesystemAdapter
     */
    private $disk;

    /**
     * @var int file end byte
     */
    private $end;

    /**
     * @var string
     */
    private $filePath;

    /**
     * Human-known filename
     *
     * @var string|null
     */
    private $humanName;

    /**
     * @var bool storing if request is a range (or a full file)
     */
    private $isRange = false;

    /**
     * @var int|null length of bytes requested
     */
    private $length = null;

    /**
     * @var array
     */
    private $returnHeaders = [];

    /**
     * @var int file size
     */
    private $size;

    /**
     * @var int start byte
     */
    private $start;

    /**
     * S3FileStream constructor.
     * @param string $filePath
     * @param string $adapter
     * @param string $humanName
     */

    public function setter(string $filePath, string $adapter = 's3', ?string $humanName = null)
    {
        $this->filePath    = $filePath;
        //Name of the storage medium(local, s3)
        $this->adapterName = $adapter;
        //Get the disk based on the selected storage
        $this->disk        = Storage::disk($this->adapterName);
        $this->adapter     = $this->disk->getAdapter();
        $this->humanName   = $humanName;
        //Set to zero until setHeadersAndStream is called
        $this->start = 0;
        $this->size  = 0;
        $this->end   = 0;
    }

    /**
     * Output file to client.
     */
    public function output()
    {
        return $this->setHeadersAndStream();
    }

    /**
     * Output headers to client.
     * @return Response|StreamedResponse
     */
    protected function setHeadersAndStream()
    {
        if (!$this->disk->exists($this->filePath)) {
            report(new Exception('S3 File Not Found in S3FileStream - ' . $this->adapterName . ' - ' . $this->disk->path($this->filePath)));
            return response('File Not Found', 404);
        }

        $this->start   = 0;
        $this->size    = $this->disk->size($this->filePath);
        $this->end     = $this->size - 1;
        $this->length  = $this->size;
        $this->isRange = false;

        //Set headers
        $this->returnHeaders = [
            'Last-Modified'       => $this->disk->lastModified($this->filePath),
            'Accept-Ranges'       => 'bytes',
            'Content-Type'        => $this->disk->mimeType($this->filePath),
            'Content-Disposition' => 'inline; filename=' . ($this->humanName ?? basename($this->filePath) . '.' . Arr::last(explode('.', $this->filePath))),
            'Content-Length'      => $this->length,
        ];

        //Handle ranges here
        if (!is_null(request()->server('HTTP_RANGE'))) {
            $cStart = $this->start;
            $cEnd   = $this->end;

            $range = Str::after(request()->server('HTTP_RANGE'), '=');
            if (strpos($range, ',') !== false) {
                return response('416 Requested Range Not Satisfiable', 416, [
                    'Content-Range' => 'bytes */' . $this->size,
                ]);
            }
            if (substr($range, 0, 1) == '-') {
                $cStart = $this->size - intval(substr($range, 1)) - 1;
            } else {
                $range  = explode('-', $range);
                $cStart = intval($range[0]);

                $cEnd = (isset($range[1]) && is_numeric($range[1])) ? intval($range[1]) : $cEnd;
            }

            $cEnd = min($cEnd, $this->size - 1);
            if ($cStart > $cEnd || $cStart > $this->size - 1) {
                return response('416 Requested Range Not Satisfiable', 416, [
                    'Content-Range' => 'bytes */' . $this->size,
                ]);
            }

            $this->start                           = intval($cStart);
            $this->end                             = intval($cEnd);
            $this->length                          = min($this->end - $this->start + 1, $this->size);
            $this->returnHeaders['Content-Length'] = $this->length;
            $this->returnHeaders['Content-Range']  = 'bytes ' . $this->start . '-' . $this->end . '/' . $this->size;
            $this->isRange                         = true;
        }

        return $this->stream();
    }

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
        if (!($stream = fopen("s3://{$this->adapter->getBucket()}/{$this->filePath}", 'rb', false, $context))) {
            throw new Exception('Could not open stream for reading export [' . $this->filePath . ']');
        }
        if (isset($this->start) && $this->start > 0) {
            fseek($stream, $this->start, SEEK_SET);
        }

        $remainingBytes = $this->length ?? $this->size;
        $chunkSize      = 100;

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