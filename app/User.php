<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    JWTSubject
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword;

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

    public function getFullnameAttribute() {
        return $this->firstname . " " . $this->lastname;
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

    public function hasRole($role) {
        if (is_array($role)) {
            return null !== $this->roles()->whereIn('role', $role)->first();
        }
        return null !== $this->roles()->where('role', $role)->first();
    }

    public function roles() {
        return $this->hasMany('App\Role', 'user_id', 'id');
    }

    public function acars_queue() {
        return $this->hasMany('App\ACARSMessageQueue', 'user_id', 'id');
    }

    public function log($data) {
        $log = new ActionLog();
        $log->user_id = $this->id;
        $log->data = $data;
        $log->save();
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [
            'user' => $this->load('roles')->toArray()
        ];
    }
}
