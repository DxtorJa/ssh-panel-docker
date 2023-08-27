@extends('layouts.master')
@section('title', 'Admin Panel - Add VPN Certificate')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>ADD NEW VPN CERTFICATE</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        NEW CERTIFICATE DETAILS
                    </h2>
                </div>
                <div class="body">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{session('message')}}
                            </div>
                        @endif
                    </div>
                	<form method="post" action="/vpn/cert/upload" method="post" enctype="multipart/form-data">
                		{{csrf_field()}}
                		<div class="row clearfix">
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="name" required>
	                                    <label class="form-label">Name</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="port" required>
	                                    <label class="form-label">Port</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
                                <p>
                                    <b>Server</b>
                                </p>
	                            <select class="form-control show-tick" name="server_id">
                                    <option value="null">-- Select Server --</option>
                                    @foreach($servers as $server)
                                        <option value="{{$server->id}}">{{$server->ip}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="">Cetificate File</label>
                                <input type="file" name="cert">
                            </div>
	                        <div class="col-lg-12 col-sm-12">
	                        	<button type="submit" class="btn btn-success pull-right" id="btn-add-reseller">SUBMIT</button>
	                        </div>
	                    </div>
                	</form>
                </div>
            </div>
        </div>

        

@endsection