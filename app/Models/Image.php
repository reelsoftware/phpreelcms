<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * Get the series that belongs to this image.
     */
    public function series()
    {
        return $this->hasOne(Series::class);
    }
}
