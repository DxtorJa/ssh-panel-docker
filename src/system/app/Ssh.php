<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ssh extends Model
{
    protected $fillable = ['reseller_email','username','at_server','status','expired_on'];

    public function note() {
    	return $this->hasOne('App\Notes', 'account_id');
    }
}
