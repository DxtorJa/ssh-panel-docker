@extends('layouts.master')
@section('title', 'vpn Account List')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST VPN ACCOUNT</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Simple Widget -->
	<div class="row clearfix">

		<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
	    	<div id="result">

	    	</div>
	    </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    	VPN ACCOUNT LIST
                    </h2>
                </div>
                <div class="body">
                	@if($vpns->count() < 1)
                		<h1 class="text-center">NO ACCOUNT FOUND</h1>
                	@else
                		<div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>USERNAME</th>
                                        <th>AT SERVER</th>
                                        <th>NOTE</th>
                                        <th>CREATED AT</th>
                                        <th>EXPIRED ON</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php $i = 1; ?>
                                    @foreach($vpns as $vpn)
                                    	<tr id="row-{{$vpn->id}}">
	                                        <th scope="row">{{$i++}}</th>
	                                        <td>{{$vpn->username}}</td>
                                          <td>{{$vpn->at_server}}</td>
	                                        <td>{{is_null($vpn->note) ? '' : $vpn->note->content}}</td>
	                                        <td>{{$vpn->created_at->format('d/m/Y')}}</td>
	                                        <td>{{\Carbon\Carbon::parse($vpn->expired_on)->format('d/m/Y')}}</td>
	                                    	<td>
	                                    		@if($user->role == 'admin')
	                                    			@if($vpn->status == 'locked')
	                                    				<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockVPNAccount({{$vpn->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
	                                    			@else
	                                    				<button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockVPNAccount({{$vpn->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
	                                    			@endif
	                                    			
                                            <button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Account" onclick="removeVPNAccount({{$vpn->id}})"><i class="material-icons" id="delete-account">delete</i></button>
	                                    		  <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Details" onclick="changeVPNDetails({{$vpn->id}})"><i class="material-icons" id="edit-account">edit</i></button>
                                            <button class="btn btn-xs bg-teal" data-toggle="tooltip" data-placement="top" title="Change Active Date" onclick="changeVPNActive({{$vpn->id}})"><i class="material-icons" id="edit-account">access_time</i></button>
                                          @else
	                                    			
                                            @if($vpn->status == 'locked')
	                                    				<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockVPNAccount({{$vpn->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
	                                    			@else
	                                    				<button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockVPNAccount({{$vpn->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
	                                    			@endif
	                                    			
                                            <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Details" onclick="changeVPNDetails({{$vpn->id}})"><i class="material-icons" id="edit-account">vpn_key</i></button>
                                            <button class="btn btn-xs bg-teal" data-toggle="tooltip" data-placement="top" title="Change Active Date" onclick="changeVPNActive({{$vpn->id}})"><i class="material-icons" id="edit-account">access_time</i></button>
	                                    		@endif
	                                    	</td>
	                                    </tr>
	                                @endforeach
                                </tbody>
                            </table>
                        </div>
                	@endif
    			</div>
			</div>
		</div>
	</div>
    <!-- End Simple Widget -->

        <!-- VPN EDIT MODAL-->

    <div id="vpnAccountEdit" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">EDIT VPN ACCOUNT DETAILS</h4>
          </div>
          <div class="modal-body" id="vpn-edit-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div id="vpnAccountActiveEdit" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">EDIT VPN ACCOUNT ACTIVE DATE</h4>
          </div>
          <div class="modal-body" id="vpn-active-edit-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

@endsection