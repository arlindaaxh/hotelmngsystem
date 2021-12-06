<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = [
        'reservation_id',
        'room_price',
        'addons',
        'total',

    ];
        //Tell laravel to fetch text values and set them as arrays
    protected $casts = [
        'addons' => 'array',
    ];

}
