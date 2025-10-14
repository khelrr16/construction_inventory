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
    ];

    public function pendingResources(){
        return $this->hasMany(ProjectResource::class, 'warehouse_id')
            ->whereIn('status', ['to be packed','packing']);
    }
}
