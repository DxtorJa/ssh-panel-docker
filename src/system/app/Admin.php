<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    
    protected $fillable = [
    	'cf_email_key','cf_api_key','setting_up','site_title','site_name','site_author','site_url','site_description', 'site_thumbnails'
    ];
}
