<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'serial_number',
        'items',
        'products',
        'total_amount',
        'payment_type',
        'guest_id',
        'employee_id',
        'status',
        'initial_qty'
    ];

    protected $casts = [
        'products' => 'array',
    ];

}
