<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trial extends Model
{
    protected $fillable = ['reseller_email', 'create_date'];
}
