<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'images','balance', 'point','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role', 'images', 'api_token'
    ];

    public function isAdmin()
    {
        if(Auth::user()->role == 'admin')
        {
            return true;
        }

        return false;
    }

    public function notifications(){
        return $this->belongsTo('App\Notif');
    }

    public function comments() {
        return $this->hasMany('App\TicketComment', 'user_id');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket', 'user_id');
    }
}
