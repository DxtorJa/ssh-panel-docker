<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'tickets_id', 'user_email', 'subject', 'priority', 'category', 'user_id'
    ];
    
    public function message() {
        return $this->belongsTo('App\TicketMessage', 'id');
    }

    public function categories() {
        return $this->belongsTo('App\TicketCategory', 'tickets_id');
    }

    public function comments() {
        return $this->hasMany('App\TicketComment', 'ticket_id');
    }

    public function user() {
        return $this->belogsTo('App\User', 'user_id');
    }
}
