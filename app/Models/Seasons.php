<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Episode;

class Seasons extends Model
{
    use HasFactory;

    /**
     * Get the episodes associated with this season.
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
