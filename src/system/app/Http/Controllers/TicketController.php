<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\TicketMessage;
use App\TicketComment;

class TicketController extends Controller
{

    public function index() {
        $user = Auth::user();;

        if($user->role == 'admin') {
            $tickets = Ticket::simplePaginate(10);

            return view('admin.ticket')->with('tickets', $tickets);
        }

        $tickets = Ticket::simplePaginate(10);

        return view('admin.ticket')->with('tickets', $tickets);

    }

    public function create() {
        $user = Auth::user();
        
        if($user->role == 'admin') {
            return abort(404);
        }

        $category = \App\TicketCategory::get();
        return view('reseller.ticket-create')->with('categories', $category);
    }

    public function store(Request $request) {
        $user = Auth::user();

        $this->validate($request, [
            'subject' => 'required',
            'category' => 'required',
            'priority' => 'required',
            'message' => 'required'
        ]);

        $ticket = Ticket::create([
            'tickets_id' => strtoupper('#' . str_random(10)),
            'user_email' => $user->email,
            'user_id' => $user->id,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'category' => $request->category,
            'status' => 'Open',
        ]);

        TicketMessage::create([
            'tickets_id' => $ticket->id,
            'user_email' => $user->email,
            'messages' => $request->message,
            'have_attachment' => false
        ]);

        return redirect('/tickets/' . encrypt($ticket->id))->with('message', 'The Ticket ' . $ticket->tickets_id . ' has been submitted!');
    }

    public function view($id) {
        $user = Auth::user();
        try {
            $id = decrypt($id);
        } catch(\Exception $e) {
            return abort(404);
        }
        
        $ticket = Ticket::where('id', $id)->first();
        if(!$ticket) {
            return abort(404);
        }

        if($user->email != $ticket->user_email) {
            if ($user->role == 'admin') {
                return view('admin.ticket-view')->with('ticket', $ticket);
            }

            return abort(404);
        }

        return view('admin.ticket-view')->with('ticket', $ticket);
    }

    public function addComment(Request $request) {
        $user = Auth::user();
        $this->validate($request, [
            'comment' => 'required'
        ]);

        if(!$request->has('comment')) {
            return redirect()->back();
        }

        if(!$request->has('_id')) {
            return redirect()->back();
        }

        $ticket = Ticket::where('id', $request->_id)->first();
        if(!$ticket) {
            return redirect()->back();
        }

        if($user->role != 'admin' && $user->email != $ticket->user_email) {
            dd('executed');
            return redirect()->back();
        }

        Ticket::where('id', $ticket->id)->update([
            'status' => 'in progress'
        ]);
        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('message', 'Your reply has been submitted!');
    }

    public function close(Request $request) {
        if(!$request->has('_id')) {
            return redirect()->back();
        }

        if(Auth::user()->role != 'admin') {
            return redirect()->back();
        }

        $ticket = Ticket::where('id', $request->_id)->first();
        if(!$ticket) {
            return redirect()->back();
        }

        Ticket::where('id', $ticket->id)->update([
            'status' => 'closed',
        ]);

        return redirect()->back()->with('message', 'Ticket ' . strtoupper($ticket->tickets_id) . ' has been closed!');
    }
}
