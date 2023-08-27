<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cert extends Model
{
    protected $fillable = [
        'server_id', 'name', 'port', 'description', 'url'
    ];

}
