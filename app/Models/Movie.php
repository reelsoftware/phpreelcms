<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'categories' => 'array',
    ];
}
