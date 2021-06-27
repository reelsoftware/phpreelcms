<?php
namespace App\Helpers\FileUpload\StorageMethods;
use App\Helpers\FileUpload\StorageMethods\IStorageStrategy;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;

/**
 * Concrete strategy class implement the payment method while following the base Strategy
 * interface. The interface makes them interchangeable in the PaymentContext.
 */
class S3Strategy implements IStorageStrategy
{
    public function __construct()
    {
        $this->storage = config('app.storage_disk');
        $this->path = 's3://' . env('AWS_BUCKET');
        $this->fileName = '';
        $this->client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => '2006-03-01',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY')
            ],
            // Set the S3 class to use objects.dreamhost.com/bucket
            // instead of bucket.objects.dreamhost.com
            'use_path_style_endpoint' => true
        ]);
        // Register the stream wrapper from an S3Client object
        $client->registerStreamWrapper();
    }    
}