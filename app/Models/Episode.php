<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seasons;
use App\Models\Series;

class Episode extends Model
{
    use HasFactory;

    public function season()
    {
        return $this->belongsTo(Seasons::class);
    }

    // Not working
    public function series()
    {
        
    }
}
