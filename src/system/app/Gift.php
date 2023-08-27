<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = ['code', 'amount', 'messages', 'is_reedemed', 'reedemed_by', 'reedemed_at'];
}
