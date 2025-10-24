<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordResetCode extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'code', 'expires_at'];
    public $timestamps = false;

    public $casts = ['expires_at' => 'datetime'];

    // Check if code is expired
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
