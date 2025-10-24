<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectResource extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'project_id',
        'created_by',
        'warehouse_id',
        'prepared_by',
        'driver_id',
        'vehicle_id',
        'approved_by',
        'remark',
        'schedule',
        'status',
    ];

    protected $casts = [
        'schedule' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(ProjectResourceItem::class, 'resource_id');
    }

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function preparer()
    {
        return $this->belongsTo(User::class,'prepared_by');
    }

    public function driver()
    {
        return $this->belongsTo(User::class,'driver_id');
    }

    public function approver(){
        return $this->belongsTo(User::class,'approved_by');
    }

    public function statusHistory(){
        return $this->hasMany(ResourceStatus::class, 'resource_id');
    }
}
