<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// dev-1.0, Ferry, 20170804, Other class declaration
use Spatie\Permission\Traits\HasRoles;      // Role and permission

class User extends Authenticatable
{
    use Notifiable;

    // dev-1.0, Ferry, 20170804, Other class uses
    use HasRoles;   // Role and permission

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
