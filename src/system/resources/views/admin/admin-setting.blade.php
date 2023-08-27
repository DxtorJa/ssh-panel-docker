@extends('layouts.master')
@section('title', 'Admin Panel - Admin Setting')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>ADMIN DASHBOARD</h2>
    </div>
    <!-- End Title Page Section -->

    @if($errors->any())
        <div class="alert alert-danger">
            <h4>Oops! Please fix the following erros.</h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Account Setting
                    </h2>
                </div>
                <div class="body">
                	<div class="row clearfix">
                        <form method="post" action="/admin/change-details" id="change-admin-password">
                        	{{csrf_field()}}

                        	<div class="col-sm-12">
	                            <div class="form-group">
	                                <div class="form-line">
                	                    <label>Username</label>
                                    
	                                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{$user->name}}" />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <div class="form-line">
                	                    <label>Email Address</label>
                                    
	                                    <input type="email" class="form-control" placeholder="Username" name="email" value="{{$user->email}}" />
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <div class="form-line">
                	                    <label>Password</label>
                                    
	                                    <input type="password" class="form-control" placeholder="New Password" name="password" />
	                                </div>
	                            </div>
	                            <button id="btn-change-admin-password" type="submit" class="btn btn-lg bg-green">Save!</button>
	                        </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Site Setting
                    </h2>
                </div>
                <div class="body">
                	<div class="row clearfix">
                        <form method="post" action="/admin/change-website-details" id="change-website-details">
                        	{{csrf_field()}}	

                        	<div class="col-sm-6">
	                            <div class="form-group">
	                                <div class="form-line">
                                        <label>Website Name</label>
                                    
	                                    <input type="text" class="form-control" placeholder="Website Name" name="site_name" value="{{$admin->site_name}}" />
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-6">
	                            <div class="form-group">
	                                <div class="form-line">
                                        <label>Website Author (Please include http:// or https://)</label>
                                    
	                                    <input type="text" class="form-control" placeholder="Website URL (include http:// or https://)" name="site_url" value="{{$admin->site_url}}" />
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-6">
	                            <div class="form-group">
	                                <div class="form-line">
                                        <label>Website Author</label>
                                    
	                                    <input type="text" class="form-control" placeholder="Website Author" name="site_author" value="{{$admin->site_author}}" />
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-6">
	                            <div class="form-group">
	                                <div class="form-line">
                                        <label>Website Title</label>
                                    
	                                    <input type="text" class="form-control" placeholder="Website Title" name="site_title" value="{{$admin->site_title}}" />
	                                </div>
	                            </div>
                            </div>
                            <div class="col-sm-6">
	                            <div class="form-group">
	                                <div class="form-line">
                                        <label>Cloudflare Email Address</label>
                                    
	                                    <input type="text" class="form-control" placeholder="Cloudflare Email API" name="cf_email" value="{{$admin->cf_email_key}}" />
	                                </div>
	                            </div>
	                        </div>
                            <div class="col-sm-6">
	                            <div class="form-group">
	                                <div class="form-line">
                                        <label>Cloudflare API Key</label>
	                                    <input type="password" class="form-control" placeholder="Cloudflare API Key" name="cf_api" value="{{$admin->cf_api_key}}" />
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                        	<button class="btn btn-lg bg-green" id="btn-change-website-details">Save!</button>
	                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Message Setting
                    </h2>
                </div>
                <div class="body">
                	<div class="row clearfix">
                        <form method="post" action="/admin/change-message" id="change-messages">
                        	{{csrf_field()}}

                        	<div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="ssh_success">{{$pesan->pesan_ssh_sukses}}</textarea>
                                        <label class="form-label">Message if successfully create SSH Account</label>
                                    </div>
                                </div>
	                            
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="ssh_failed">{{$pesan->pesan_ssh_gagal}}</textarea>
                                        <label class="form-label">Message if Failed to create SSH Account</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="vpn_success">{{$pesan->pesan_vpn_sukses}}</textarea>
                                        <label class="form-label">Message if successfully create VPN Account</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="vpn_failed">{{$pesan->pesan_ssh_gagal}}</textarea>
                                        <label class="form-label">Message if Failed to create VPN Account</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="trial_success">{{$pesan->pesan_trial_sukses}}</textarea>
                                        <label class="form-label">Message if successfully create Trial Account</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="trial_failed">{{$pesan->pesan_trial_sukses}}</textarea>
                                        <label class="form-label">Message if Failed to create Trial Account</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                    	<textarea class="form-control" rows="5" name="balance_min">{{$pesan->pesan_saldo_tidak_cukup}}</textarea>
                                        <label class="form-label">Message if balance or point not meet account prices.</label>
                                    </div>
                                </div>

	                            <button id="btn-change-messages" type="submit" class="btn btn-lg bg-green">Save!</button>
	                        </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection