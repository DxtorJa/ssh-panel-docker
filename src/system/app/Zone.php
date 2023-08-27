<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
    	'zone_id', 'zone_name', 'zone_count'
    ];
}
