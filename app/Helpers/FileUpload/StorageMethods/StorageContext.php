<?php
namespace App\Helpers\FileUpload\StorageMethods;

use Illuminate\Http\Request;

/**
 * The Context defines the interface for payment
 */
class StorageContext
{
    /**
     * @var IStorageStrategy Reference to one concrete storage strategy to be used
     */
    private $storageStrategy;

    /**
     * Replace the strategy at runtime depending on what storage medium is selected
     */
    public function setStorageStrategy(IStorageStrategy $strategy)
    {
        $this->storageStrategy = $strategy;
    }

    /**
     * Execute the payment and return true for successful payments and 
     */
    public function execute(Request $request)
    {
        return $this->storageStrategy->upload($request);
    }
}