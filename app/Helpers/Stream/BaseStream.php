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

abstract class BaseStream
{
    /**
     * @var \League\Flysystem\AwsS3v3\AwsS3Adapter
     */
    protected $adapter;

    /**
     * Name of adapter
     *
     * @var string
     */
    protected $adapterName;

    /**
     * Storage disk
     *
     * @var FilesystemAdapter
     */
    protected $disk;

    /**
     * @var int file end byte
     */
    protected $end;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var bool storing if request is a range (or a full file)
     */
    protected $isRange = false;

    /**
     * @var int|null length of bytes requested
     */
    protected $length = null;

    /**
     * @var array
     */
    protected $returnHeaders = [];

    /**
     * @var int file size
     */
    protected $size;

    /**
     * @var int start byte
     */
    protected $start;

    /**
     * S3FileStream constructor.
     * @param string $filePath
     * @param string $adapter
     * @param string $humanName
     */
    public function setter(string $filePath, string $adapter = 's3')
    {
        $this->filePath    = $filePath;
        //Name of the storage medium(local, s3)
        $this->adapterName = $adapter;
        //Get the disk based on the selected storage
        $this->disk        = Storage::disk($this->adapterName);
        $this->adapter     = $this->disk->getAdapter();

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
            'Content-Disposition' => 'inline; filename=' . basename($this->filePath) . '.' . Arr::last(explode('.', $this->filePath)),
            'Content-Length'      => $this->length,
        ];


        //dd(request()->server());

        
        //Handle ranges here
        if (!is_null(request()->server('HTTP_RANGE'))) 
        {
            $cStart = $this->start;
            $cEnd   = $this->end;

            //Get the bytes ranges
            $range = Str::after(request()->server('HTTP_RANGE'), '=');

            if (strpos($range, ',') !== false) 
            {
                return response('416 Requested Range Not Satisfiable', 416, [
                    'Content-Range' => 'bytes */' . $this->size,
                ]);
            }

            //If true, it means is the first chunk of the range (Range: bytes=0-)
            if (substr($range, 0, 1) == '-') 
                $cStart = $this->size - intval(substr($range, 1)) - 1;
            //Else it means it not the first chunk so it has two values (Range: bytes=64312833-64657026)
            else 
            {
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

    //abstract protected function stream(): StreamedResponse;
}