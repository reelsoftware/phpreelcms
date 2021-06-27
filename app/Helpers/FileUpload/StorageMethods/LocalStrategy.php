<?php
namespace App\Helpers\FileUpload\StorageMethods;
use App\Helpers\FileUpload\StorageMethods\IStorageStrategy;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Concrete strategy class implement the payment method while following the base Strategy
 * interface. The interface makes them interchangeable in the PaymentContext.
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
        $this->path = base_path().'/storage';
        $this->fileName = '';
    }    

    //Add a new resource 
    //$file = $request->file('name');
    private function storeResource($file)
    {
        $fileName = time() . Str::random(26) . '.' . $file->extension();

        if(config('app.storage_disk') == 's3')
            $filePath = 'resources/' . $fileName;
        else 
            $filePath = $fileName;
            
        Storage::disk(config('app.storage_disk'))->put($filePath, file_get_contents($file));

        return $fileName;
    }

    /**
     * Implementation of the upload method from the interface
     */
    public function upload(Request $request)
    {
        //If it's the first chunk then create a new file
        if($request->videoId == '')
        {
            $this->fileName = $this->storeResource($request->file('file'));
            $this->path .= '/app/resources/' . $this->fileName;
        }
        else  
        {
            //If the file is already created then append to it the next chunk

            //Set file name from previous chunk
            $this->fileName = $request->videoId;

            $this->path .= '/app/resources/' . $this->fileName;

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