<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = [
    	'title','thumbnail', 'category','body','posted_by','slug',
    ];
}
