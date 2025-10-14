<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceStatus extends Model
{
    protected $fillable = [
        'project_id',
        'resource_id',
        'status',
        'description',
    ];
}
