<?php
namespace App\Helpers\FileUpload\StorageMethods;
use Illuminate\Http\Request;


/**
 * IStorageStrategy declares operations common to all uploading strategies
 *
 * This is used inside StorageContext to call the appropriate strategy
 */
interface IStorageStrategy
{
    /**
     * Method used to upload files chunk by chunk
     */
    public function upload(Request $request);
}