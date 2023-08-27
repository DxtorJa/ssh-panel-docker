@extends('layouts.master')
@section('title', 'Ticket ' . strtoupper($ticket->tickets_id) . ' - ' . $ticket->subject)
@section('body')
	<div class="block-header">
        <h2>View Ticket</h2>
    </div>

    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
            @endif
        </div>
    </div>

    <div class="log-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        {{strtoupper($ticket->tickets_id)}} - {{$ticket->subject}} 
                        <small>{{user($ticket->user_id)->name}}'s said...</small>
                    </h2>
    
                </div>
                <div class="body">
                    
                    {{$ticket->message->messages}}
                
                    <hr>
                    <p class="pull-right">{{$ticket->created_at->diffForHumans()}}...</p>
                    <br>
                </div>
            </div>
        </div>

        @foreach($ticket->comments as $comment)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-{{$comment->user->role == 'admin' ? 'light-blue' : 'light-green'}}">
                        <h2>
                            @if(Auth::user()->id == $comment->user->id)
                                You Commented :
                            @else
                                @if($comment->user->role == 'admin')
                                    Admin Commented :
                                @else 
                                    {{ucfirst($comment->user->name)}} commented :
                                @endif
                            @endif
                        </h2>
        
                    </div>
                    <div class="body">
                        {{$comment->comment}}
                    
                        <hr>
                        <p class="pull-right">{{$ticket->created_at->diffForHumans()}}...</p>
                        <br>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body bg-white">
                    <form action="/tickets/comments" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="_id" value="{{$ticket->id}}">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <textarea rows="4" type="text" class="form-control" name="comment"></textarea>
                                <label class="form-label">Reply :</label>
                            </div>
                        </div>
                        <button class="btn btn-success pull-right" >SUBMIT</button>
                        <br />
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="card">
            <div class="header bg-grey">
                <h2>
                    Ticket Details
                </h2>
            </div>
            <div class="body">
                <ul class="list-group">
                    <li class="list-group-item">Ticket ID 
                        <span class="badge bg-pink">{{strtoupper($ticket->tickets_id)}}</span>
                    </li>
                    <li class="list-group-item">Status 
                        {!! ticket_status_badge($ticket->id) !!}
                    </li>
                    <li class="list-group-item">Category
                        <span class="badge bg-teal">{{@category($ticket->category)->name}}</span>
                    </li>
                    <li class="list-group-item">Priority 
                        {!! ticket_priority_badge($ticket->id) !!}
                    </li>
                    <li class="list-group-item">Comments
                        <span class="badge bg-purple">{{$ticket->comments()->count()}}</span></li>
                </ul>
            </div>
        </div>
        @if(Auth::user()->role == 'admin')
            <form action="/tickets/close" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_id" value="{{$ticket->id}}">
                <button type="submit" class="btn btn-success btn-lg" style="width: 100%">CLOSE TICKET</button>
            </form>
        @endif
    </div>
               
    
@endsection