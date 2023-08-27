<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vpn extends Model
{
    protected $fillable = [
    	'username','reseller_email','at_server','status','expired_on'
    ];

    public function note() {
    	return $this->hasOne('App\Notes', 'account_id');
    }
}
