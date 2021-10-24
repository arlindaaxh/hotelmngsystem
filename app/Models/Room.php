<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'type',
        'code',
        'number',
        'status',
        'facilities',
        'cleaning_status'

    ];
        //Tell laravel to fetch text values and set them as arrays
    protected $casts = [
        'facilities' => 'array',
    ];
        
}