<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; // JWT token
// dev-1.0, Ferry, 20170804, Other class declaration
use Spatie\Permission\Traits\HasRoles;      // Role and permission

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;   // Role and permission

    //Constanta
    CONST RECEIVE_TORIMETRON_NOTIF = '1';
    CONST NOT_RECEIVE_TORIMETRON_NOTIF = '0';

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
