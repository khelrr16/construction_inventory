<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'description',
        'subject_id', 
        'subject_type',
        'user_id',
        'properties',
        'host'
    ];

    protected $casts = [
        'properties' => 'array'
    ];
    
    public function subject()
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
