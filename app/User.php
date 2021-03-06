<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'sur_name', 'middle_name', 'phone', 'email', 'password', 'usertype', 'iin', 'bin','role_id', 'password_changed_at','current_login_at','last_login_at','last_failed_login_at',
        'last_login_ip','last_failed_login_ip',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }


    public function scopeActive($query) {
        return $query->where('usertype', NULL );
    }

    public function isAdmin()
    {
        return $this->role->name === 'Admin';
    }

}
