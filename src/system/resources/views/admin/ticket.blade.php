@extends('layouts.master')
@section('title', 'Admin Panel - Tickets List')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST TICKETS</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        LIST Tickets
                    </h2>
                </div>
                <div class="body">
                	@if($tickets->count() < 1)
                		<h1 class="text-center">NO TICKETS FOUND</h1>
                	@else
	                	<div class="table-responsive">
	                		<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FROM</th>
                                        <th>CATEGORY</th>
                                        <th>TITLE</th>
                                        <th>STATUS</th>
                                        <th>CREATED AT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php $i = 1; ?>
                                    @foreach($tickets as $ticket)
                                    	<tr id="row-{{$ticket->id}}">
	                                        <th scope="row">{{$i++}}</th>
	                                        <td>{{$ticket->user_email}}</td>
                                            <td>{{@category($ticket->category)->name}}</td>
                                            <td>{{strtoupper($ticket->tickets_id)}} - {{str_limit($ticket->subject, 50)}}</td>
	                                        <td>
                                                @if($ticket->status == 'opened')
                                                    <label class="label label-success">{{$ticket->status}}</label>
                                                @elseif($ticket->status == 'in progress')
                                                    <label class="label label-warning">{{$ticket->status}}</label>
                                                @else
                                                    <label class="label label-danger">{{$ticket->status}}</label>
                                                @endif
                                            </td>
	                                        <td>{{$ticket->created_at->format('d/m/Y')}}</td>
	                                        <td>
                                                <a href="/tickets/{{encrypt($ticket->id)}}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="View Ticket"><i class="material-icons">remove_red_eye</i></a>
	                                        </td>
	                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {!! $tickets->links('vendor.pagination.simple-bootstrap-4') !!}
                      
                      @endif
                </div>
            </div>
        </div>
    </div>
@endsection