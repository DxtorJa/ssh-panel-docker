<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $fillable = [
        'tickets_id', 'user_email', 'messages', 'have_attachment'
    ];

    protected $table = 'tickets_messages';
}
