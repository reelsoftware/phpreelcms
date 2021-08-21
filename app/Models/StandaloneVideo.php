<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandaloneVideo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'standalone_videos';

    /**
     * Get the video file associated with the standalone video.
     */
    public function videoFile()
    {
        return $this->hasOne(Video::class, "id", "video")->first();
    }
}
