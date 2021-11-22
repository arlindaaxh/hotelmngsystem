<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'phone_number',
        'birth_date',
        'personal_number',
        'citizenship',
        'sex'
    ];
}
