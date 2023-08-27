<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VPNSoftware extends Model
{
    protected $table = 'vpn_software';

    protected $fillable = [
    	'server_id', 'type', 'l2tp_password'
    ];
}
