<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category', 
        'name', 
        'description', 
        'cost', 
        'measure',
        'stocks',
    ];

    // public function modifiedBy()
    // {
    //     return $this->belongsTo(User::class, 'modified_by');
    // }
}
