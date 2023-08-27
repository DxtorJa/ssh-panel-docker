<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = 'account_notes';

    protected $fillable = [
    	'account_id', 'content'
    ];
}
