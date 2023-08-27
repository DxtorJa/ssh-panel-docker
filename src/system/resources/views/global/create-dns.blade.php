@extends('layouts.master')
@section('title', 'Create DNS Records')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>CREATE DNS</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        CREATE DNS
                    </h2>
                </div>
                <div class="body">
                	<form id="create-dns" method="post">
                		<div class="row clearfix">
                			{{csrf_field()}}

	                        <div class="col-sm-12 col-lg-4">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="hostname">
	                                    <label class="form-label">Hostname</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12 col-lg-4">
	                            <select class="form-control show-tick" name="zone">
	                        		@if($zones->count() < 1)
	                            		<option>-- NO DNS SERVER FOUND --</option>
	                            	@else
	                            		<option>-- CHOOSE DNS SERVER --</option>
	                            		@foreach($zones as $zone)
	                            			<option value="{{$zone->zone_name}}">{{$zone->zone_name}}</option>
	                            		@endforeach
	                            	@endif
	                            </select>
	                        </div>
	                        <div class="col-sm-12 col-lg-4">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="ip">
	                                    <label class="form-label">Remote IP</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-12 col-sm-12">
	                        	<hr />
	                        	<button class="btn btn-success text-center" style="width: 100%" type="submit" id="btn-create-dns" onclick="createDNS()">CREATE</button>
	                        </div>
	                    </div>
                	</form>
                </div>
            </div>
        </div>
    </div>
@endsection