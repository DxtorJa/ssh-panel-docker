<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Vpn;
use App\Ssh;
use App\Notif;
use App\Server;
use App\Dns;
use App\Ticket;
use App\Admin;

class MainController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->isAdmin())
        {
            
            $reseller = User::where('role', 'reseller')->get();
            $server = Server::get();
            $ssh = Ssh::get();
            $vpn = Vpn::get();
            $notif = Notif::get();
            $ssh_active = Ssh::where('status', 'active')->get();
            $ssh_inactive = Ssh::where('status', '!=', 'active')->get();
            $vpn_active = Vpn::where('status', 'active')->get();
            $vpn_inactive = Vpn::where('status', '!=', 'active')->get();
            $tickets = Ticket::get();
            $ticket_open = Ticket::where('status', 'opened')->get();
            $ticket_closed = Ticket::where('status', 'closed')->get();
            $ticket_pending = Ticket::where('status', 'pending')->get();

            return view('admin.index')
                -> with('resellers', $reseller)
                -> with('servers', $server)
                -> with('sshs', $ssh)
                -> with('vpns', $vpn)
                -> with('notifs', $notif)
                -> with('user', $user)
                -> with('ssh_active', $ssh_active)
                -> with('ssh_inactive', $ssh_inactive)
                -> with('vpn_active', $vpn_active)
                -> with('vpn_inactive', $vpn_inactive)
                -> with('tickets', $tickets)
                -> with('ticket_open', $ticket_open)
                -> with('ticket_closed', $ticket_closed)
                -> with('ticket_pending', $ticket_pending);
        }

        $server = Server::get();
        $ssh = Ssh::where('reseller_email', $user->email)->where('status', '!=', 'trial')->get();
        $vpn = Vpn::where('reseller_email', $user->email)->where('status', '!=', 'trial')->get();
        $notif = Notif::where('user_email', $user->email)->get();
        $ssh_active = Ssh::where('status', 'active')->where('reseller_email', $user->email)->get();
        $ssh_inactive = Ssh::where('status', '!=', 'active')->get();
        $vpn_active = Vpn::where('status', 'active')->where('reseller_email', $user->email)->get();
        $vpn_inactive = Vpn::where('status', '!=', 'active')->get();
        $dns = DNS::where('reseller_email', $user->email)->get();
        $tickets = Ticket::where('user_email', $user->email)->get();
        $ticket_open = Ticket::where('status', 'opened')->where('user_email', $user->email)->get();
        $ticket_closed = Ticket::where('status', 'closed')->where('user_email', $user->email)->get();
        $ticket_pending = Ticket::where('status', 'pending')->where('user_email', $user->email)->get();


        return view('reseller.index')
            -> with('servers', $server)
            -> with('sshs', $ssh)
            -> with('vpns', $vpn)
            -> with('notifs', $notif)
            -> with('user', $user)
            -> with('ssh_active', $ssh_active)
            -> with('ssh_inactive', $ssh_inactive)
            -> with('vpn_active', $vpn_active)
            -> with('vpn_inactive', $vpn_inactive)
            -> with('dnss', $dns)
            -> with('tickets', $tickets)
            -> with('ticket_open', $ticket_open)
            -> with('ticket_closed', $ticket_closed)
            -> with('ticket_pending', $ticket_pending);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
