<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousekeepingHistory extends Model
{
    protected $fillable = [
        'room_id',
        'employee_id',
    ];
}
