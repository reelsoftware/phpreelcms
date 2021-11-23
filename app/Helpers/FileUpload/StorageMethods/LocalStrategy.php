<?php
namespace App\Helpers\FileUpload\StorageMethods;
use App\Helpers\FileUpload\StorageMethods\IStorageStrategy;
use App\Helpers\FileUpload\UploadHandler;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use Log;
/**
 * Concrete strategy class implement the uploading method while following the base Strategy
 * interface. The interface makes them interchangeable in the StorageContext.
 */
class LocalStrategy implements IStorageStrategy
{
    /**
    * @var string path to where the files are stored
    */
    private $path;

    /**
    * @var string name of the stored file
    */
    private $fileName;

    public function __construct()
    {
        $this->path = base_path() . '/storage';
        $this->fileName = '';
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
            $this->fileName = UploadHandler::storeResource($request->file('file'), 'local');
            $this->path .= $this->fileName;
        }
        else  
        {
            //If the file is already created then append to it the next chunk

            //Set file name from previous chunk
            $this->fileName = $request->videoId;

            $this->path .= "/app/resources/$this->fileName";

            //Get the files chunks that were already saved
            $savedChunks = fopen($this->path, 'a');
            
            Log::debug($this->path);
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