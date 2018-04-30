<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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

    protected $appends = ['PilotID'];

    public function getPilotIDAttribute() {
        return $this->pilotID();
    }

    /**
     * @param bool $zeropad
     * @return string
     */
    public function pilotID($zeropad = false) {
        if ($zeropad)
            return sprintf("%s%04d", env('AIRLINE_CODE', 'ZZZ'), $this->pilotnumber);
        else
            return sprintf("%s%d", env('AIRLINE_CODE', 'ZZZ'), $this->pilotnumber);
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}
