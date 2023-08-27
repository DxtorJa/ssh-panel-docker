<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dns extends Model
{
    protected $fillable = [
    	'reseller_email','subdomain','pointed_to','record_id','zone_id'
    ];
}
