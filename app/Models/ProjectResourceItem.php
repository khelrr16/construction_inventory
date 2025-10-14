<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectResourceItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'project_id',
        'resource_id',
        'item_id',
        'quantity',
        'supplied',
        'completed',
        'missing',
        'broken',
        'status',
    ];

    public function details(){
        return $this->belongsTo(Item::class, 'item_id');
    }
}
