<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Seasons;

class Series extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'image_id'
    ];

    /**
     * Get the thumbnail associated with the series.
     */
    public function thumbnail()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    // public function season()
    // {
    //     return $this->hasMany(Seasons::class, 'series_id');
    // }

    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
    
}
