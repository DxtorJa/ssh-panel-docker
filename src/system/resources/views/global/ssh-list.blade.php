@extends('layouts.master')
@section('title', 'SSH Account List')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST SSH ACCOUNT</h2>
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
                    	SSH ACCOUNT LIST
                    </h2>
                </div>
                <div class="body">
                	@if($sshs->count() < 1)
                		<h1 class="text-center">NO ACCOUNT FOUND</h1>
                	@else
                		<div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>USERNAME</th>
                                        <th>AT SERVER</th>
                                        <th>NOTE </th>
                                        <th>CREATED AT</th>
                                        <th>EXPIRED ON</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php $i = 1; ?>
                                    @foreach($sshs as $ssh)
                                    	<tr id="row-{{$ssh->id}}">
	                                        <th scope="row">{{$i++}}</th>
	                                        <td>{{$ssh->username}}</td>
                                          <td>{{$ssh->at_server}}</td>
	                                        <td>{{is_null($ssh->note) ? '' : $ssh->note->content}}</td>
	                                        <td>{{$ssh->created_at->format('d/m/Y')}}</td>
	                                        <td>{{\Carbon\Carbon::parse($ssh->expired_on)->format('d/m/Y')}}</td>
	                                    	<td>
	                                    		@if($user->role == 'admin')
	                                    			@if($ssh->status == 'locked')
	                                    				<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockSSHAccount({{$ssh->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
	                                    			@else
	                                    				<button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockSSHAccount({{$ssh->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
	                                    			@endif
	                                    			<button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Account" onclick="removeSSHAccount({{$ssh->id}})"><i class="material-icons" id="delete-account">delete</i></button>
	                                    			<button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Details" onclick="changeSSHDetails({{$ssh->id}})"><i class="material-icons" id="edit-account">edit</i></button>
                                                    <button class="btn btn-xs bg-teal" data-toggle="tooltip" data-placement="top" title="Change Active Date" onclick="changeSSHActive({{$ssh->id}})"><i class="material-icons" id="edit-account">access_time</i></button>
                                                @else
	                                    			@if($ssh->status == 'locked')
	                                    				<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockSSHAccount({{$ssh->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
	                                    			@else
	                                    				<button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockSSHAccount({{$ssh->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
	                                    			@endif
                                                    <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Details" onclick="changeSSHDetails({{$ssh->id}})"><i class="material-icons" id="edit-account">vpn_key</i></button>
	                                    			<button class="btn btn-xs bg-teal" data-toggle="tooltip" data-placement="top" title="Change Active Date" onclick="changeSSHActive({{$ssh->id}})"><i class="material-icons" id="edit-account">access_time</i></button>
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

    <!-- SSH EDIT MODAL-->

    <div id="sshAccountEdit" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">EDIT SSH ACCOUNT DETAILS</h4>
          </div>
          <div class="modal-body" id="ssh-edit-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div id="sshAccountActiveEdit" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">EDIT SSH ACCOUNT ACTIVE DATE</h4>
          </div>
          <div class="modal-body" id="ssh-active-edit-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

@endsection