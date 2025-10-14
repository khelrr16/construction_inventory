<?php

namespace App\Models;

use App\Models\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'created_by',
        'worker_id',
        'project_name',
        'description',
        'status',
        'remark',
        'house',
        'barangay',
        'city',
        'province',
        'zipcode'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'project_items', 'project_id', 'item_id')
                    ->withPivot(['id','quantity'])   // include extra pivot field
                    ->withTimestamps();       // optional: track created_at / updated_at
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function worker()
    {
        return $this->belongsTo(User::class,'worker_id');
    }

    public function resources()
    {
        return $this->hasMany(ProjectResource::class, 'project_id');
    }
}
