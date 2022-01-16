<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seasons;

class Episode extends Model
{
    use HasFactory;

    /**
     * Get the season that belongs to the episode.
     */
    public function season()
    {
        return $this->belongsTo(Seasons::class);
    }
}
