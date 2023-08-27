@extends('layouts.master')
@section('title', 'Admin Panel - Server List')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST SERVER</h2>
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
                            SERVER LIST
                            <small>Basic details of server monitoring.</small>
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        @if($servers->count() < 1)
                            <h1 class="text-center">NO SERVER AVAILABLE</h1>
                        @else
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SERVER NAME</th>
                                    <th>SERVER IP</th>
                                    <th>SERVER USER</th>
                                    <th>SERVER TYPE</th>
                                    <th>SERVER DAILY</th>
                                    <th>SERVER ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($servers as $server)       
                                    <tr id="row-{{$server->id}}">
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$server->name}}</td>
                                        <td>{{$server->ip}}</td>
                                        <td>{{$server->user_created}}</td>
                                        <td><span class="badge bg-pink">{{($server->type == 'both') ? 'SSH & VPN' : $server->type}}</span></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {{round($server->user_created / $server->limit_day * 100)}}%">
                                                    {{round($server->user_created / $server->limit_day * 100)}}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Server" onclick="deleteServer({{$server->id}})"><i class="material-icons">delete</i></button>
                                            <a href="/server/monitor" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Monitor Server"><i class="material-icons">remove_red_eye</i></a>
                                            <button class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Setting Server" onclick="settingServer({{$server->id}})"><i class="material-icons">build</i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="serverSettingModal" class="modal fade" role="dialog">
              <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">SERVER SETTINGS</h4>
              </div>
              <div class="modal-body" id="server-setting-modal">
               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>

          </div>
        </div>
	</div>
    <!-- End Simple Widget -

@endsection