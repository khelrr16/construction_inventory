<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'type',
        'brand',
        'color',
        'model',
        'plate_number',
        'registered_by',
        'status',
    ];
}
