<?php
namespace App\Helpers\FileUpload\StorageMethods;

use App\Helpers\FileUpload\StorageMethods\IStorageStrategy;
use App\Helpers\FileUpload\UploadHandler;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;

/**
 * Concrete strategy class implement the uploading method while following the base Strategy
 * interface. The interface makes them interchangeable in the StorageContext.
 */
class S3Strategy implements IStorageStrategy
{
    /**
    * @var string path to where the files are stored
    */
    private $path;

    /**
    * @var string name of the stored file
    */
    private $fileName;

    /**
    * @var string client used to interact with Amazon S3
    */
    private $client;

    public function __construct()
    {
        $this->path = 's3://' . env('AWS_BUCKET');
        $this->fileName = '';
        $this->client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => '2006-03-01',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY')
            ],
            'use_path_style_endpoint' => true
        ]);

        // Register the stream wrapper from an S3Client object
        $this->client->registerStreamWrapper();
    }    

    /**
     * Implementation of the upload method from the interface
     * @param Request $request request object
     * @return array assoc array of the videoId and path used by the ajax uploader script
     */
    public function upload(Request $request)
    {
        //If it's the first chunk then create a new file
        if($request->videoId == '')
        {
            $this->fileName = UploadHandler::storeResource($request->file('file'), 's3');
            $this->path .= "/resources/$this->fileName";
        }
        else  
        {
            //If the file is already created then append to it the next chunk

            //Set file name from previous chunk
            $this->fileName = $request->videoId;

            $this->path .= "/resources/$this->fileName";

            //Get the files chunks that were already saved
            $savedChunks = fopen($this->path, 'a');

            //Update the saved chunks with the new chunk
            fwrite($savedChunks, file_get_contents($request->file('file')));
            fclose($savedChunks);
        }

        return [
            'videoId' => $this->fileName,
            'path' => $this->path
        ];
    }   
}