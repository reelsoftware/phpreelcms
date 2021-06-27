<?php
namespace App\Helpers\FileUpload\StorageMethods;
use Illuminate\Http\Request;


/**
 * IPaymentStrategy declares operations common to all payment strategies
 *
 * This is used inside PaymentContext to call the appropriate strategy
 */
interface IStorageStrategy
{
    /**
     * Method used to upload files chunk by chunk
     */
    public function upload(Request $request);
}