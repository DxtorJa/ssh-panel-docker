<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = ['name','ip','user','pass','country','type','limit','limit_day','points', 'price','user_created','total_user','price_point'];

    protected $hidden = ['updated_at', 'pass', 'user'];

    public function certs() {
        return $this->hasMany('App\Cert', 'server_id');
    }

    public function vpn_software() {
    	return $this->hasOne('App\VPNSoftware', 'server_id');
    }
}
