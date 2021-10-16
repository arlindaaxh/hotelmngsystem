<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'job_title',
        'phone',
        'active',
        'department_id'
    ];
}
