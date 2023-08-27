<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $fillable = ['user_email', 'message', 'color', 'icons', 'callback'];
}
