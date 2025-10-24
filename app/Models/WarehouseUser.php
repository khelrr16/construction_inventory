<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseUser extends Model
{
    protected $fillable = [
        'user_id',
        'warehouse_id',
    ];

    public function warehouse(){
        return $this->hasOne(Warehouse::class, 'warehouse_id');
    }

}
