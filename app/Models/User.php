<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'dateOfBirth',
        'telNo',
        'bazaarName',
        'dutyName',
    ];

    /**
     * Determine if the user has the 'admin' role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if the user has the 'volunteer' role.
     *
     * @return bool
     */
    public function isVolunteer()
    {
        return $this->role === 'volunteer';
    }

    /**
     * Determine if the user has the 'volunteer' role.
     *
     * @return bool
     */
    public function isBazaarLeader()
    {
        return $this->role === 'bazaar_leader';
    }

    public function bazaar()
    {
        return $this->belongsTo(Bazaar::class, 'bazaarLeader', 'name');
    }

    public function bazaars()
    {
        return $this->belongsToMany(Bazaar::class);
    }

    public function duty()
    {
        return $this->hasOne(Duty::class, 'bazaarName', 'bazaarName');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}