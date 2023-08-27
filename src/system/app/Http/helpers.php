<?php 

use App\Ticket;
use App\TicketCategory;

/**
 * Helpers for projects.
 *
 */

function encrypts($string)
{
	return $string;
}

function category($id) {
	$category = TicketCategory::where('id', $id)->first();
	if($category) {
		return $category;
	}

	return '';
}

function ticket_status_badge($id) {
	$ticket = Ticket::where('id', $id)->first();

	if(!$ticket) {
		return '';
	}
	
	switch ($ticket->status) {
		case 'opened':
			return '<span class="badge bg-green">' . $ticket->status . '</span>';
		break;
		case 'in progress':
			return '<span class="badge bg-yellow">' . $ticket->status . '</span>';
		break;
		case 'closed':
			return '<span class="badge bg-red">' . $ticket->status . '</span>';
		break;			
		default:
			return '';
			break;
	}
}

function ticket_priority_badge($id)
{
    $ticket = Ticket::where('id', $id)->first();

    if (!$ticket) {
        return '';
    }

    switch (strtolower($ticket->priority)) {
        case 'low':
            return '<span class="badge bg-green">' . $ticket->priority . '</span>';
            break;
        case 'medium':
            return '<span class="badge bg-yellow">' . $ticket->priority . '</span>';
            break;
        case 'high':
            return '<span class="badge bg-red">' . $ticket->priority . '</span>';
            break;
        default:
            return '';
            break;
    }
}

function user($id) {
	$user = App\User::find($id)->first();

	if(!$user) {
		return '';
	}

	return $user;
}

function server($id) {
	if (filter_var($id, FILTER_VALIDATE_IP)) {
		
		$server = App\Server::where('ip', $id)->first();

		if(!$server) {
			return '';
		}

		return $server;

	} else {
	

		$server = App\Server::where('id', $id)->first();

		if(!$server) {
			return '';
		}

		return $server;

	}	
}

function feature($key) {
	return app('features')->get($key);
}