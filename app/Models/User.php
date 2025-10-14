<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'contact_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employeeCode()
    {
        $prefixes = [
            'site_worker'     => 'WRK-',
            'inventory_clerk' => 'CLK-',
            'admin'           => 'ADM-',
            'driver'          => 'DRV-',
        ];

        $prefix = $prefixes[$this->role] ?? 'EMP-';
        $formattedNumber = str_pad($this->id, 3, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }

    public function createdProjects()
    {
        return $this->hasMany(Projects::class, 'created_by')->get();
    }

    public function assignedProjects()
    {
        return $this->hasMany(Projects::class,'worker_id')->get();
    }

    public function warehouse()
    {
        return $this->hasOne(WarehouseUser::class,'user_id');
        // return $this->belongsToMany(Warehouse::class, 'warehouse_users')
        //             ->withTimestamps();
    }
}
