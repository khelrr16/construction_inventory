<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes, Auditable;
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
