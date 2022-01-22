<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seasons;
use App\Models\Video;
use App\Models\Image;

class Episode extends Model
{
    use HasFactory;

    public function season()
    {
        return $this->belongsTo(Seasons::class);
    }

    public function videos()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
