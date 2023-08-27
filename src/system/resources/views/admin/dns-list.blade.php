@extends('layouts.master')
@section('title', 'Admin Panel - Add DNS')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>DNS ZONE LIST</h2>
    </div>
    <!-- End Title Page Section -->


    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ADD NEW DNS DOMAIN
                    </h2>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#home_with_icon_title" data-toggle="tab">
                                <i class="material-icons">playlist_add</i> ADD NEW DOMAIN
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#profile_with_icon_title" data-toggle="tab">
                                <i class="material-icons">list</i> SELECT EXISTING DOMAIN
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                            <hr />
                            <div class="alert alert-info">
                            	Add new domain to serve DNS Function and save it on Cloudflare.
                            </div>
                            <label>Domain Name :</label>

                            <div class="row clearfix">
	                        	<div class="col-sm-6 col-lg-12">

		                        	<form method="post" id="add-domain">
		                        		{{csrf_field()}}
		                                <div class="form-group">
		                                    <div class="form-line">
		                                        <input type="text" class="form-control" placeholder="example.com" name="domain" />
		                                    </div>
		                                </div>

		                         		<button class="btn btn-success" type="submit" id="btn-add-domain" onclick="addDomainManual()">Save!</button>
		                        	</form>
	                        		
	                            </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                            <hr />
                            <div class="alert alert-info">
                            	All Domain listed below is taken from Cloudflare Account by the API Key.
                            </div>
                            	<div class="table-responsive">
                            		<table class="table">
					                    <thead>
					                        <tr>
					                            <th>DOMAIN ID</th>
					                            <th>DOMAIN NAME</th>
					                            <th>DOMAIN STATUS</th>
					                            <th>DOMAIN OWNER</th>
					                            <th>DOMAIN ACTION</th>
					                        </tr>
					                    </thead>
					                    <tbody>
					                        <?php $i = 1; ?>
					                        @foreach($results as $zone)       
					                            <tr id="row-{{$zone['id']}}">
					                            	<td>{{str_limit($zone['id'],15)}}</td>
					                            	<td>{{$zone['name']}}</td>
					                            	<td>{{$zone['status']}}</td>
					                            	<td>{{$zone['owner']['email']}}</td>
					                            	<td>
					                            		<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Add This Domain" onclick="addDomain('{{$zone['id']}}')"><i class="material-icons">check</i></button>
					                            		<button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Remove This Domain" onclick="removeDomain('{{$zone['id']}}')"><i class="material-icons">delete</i></button>
					                            	</td>
					                            </tr>
					                        @endforeach
					                    </tbody>
		                			</table>
                            	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection