<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes, Auditable;
    protected $fillable = [
        'name',
        'house',
        'barangay',
        'city',
        'province',
        'zipcode',
        'status',
    ];

    public function projectResources()
    {
        return $this->hasMany(ProjectResource::class, 'warehouse_id');
    }

    public function warehouseUsers(){
        return $this->hasMany(WarehouseUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'warehouse_users');
    }

    public function items(){
        return $this->hasMany(Item::class, 'warehouse_id');
    }
}
