<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;
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
