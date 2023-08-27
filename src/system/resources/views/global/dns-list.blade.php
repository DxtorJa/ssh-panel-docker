@extends('layouts.master')
@section('title', 'DNS List')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST DNS</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        LIST DNS
                    </h2>
                </div>
                <div class="body">
                	@if($dns->count() < 1)
                		<h1 class="text-center">NO DNS RECORD FOUND</h1>
                	@else
	                	<div class="table-responsive">
	                		<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SUBDOMAIN</th>
                                        <th>POINTED TO</th>
                                        <th>CREATED AT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php $i = 1; ?>
                                    @foreach($dns as $zone)
                                    	<tr id="row-{{$zone->id}}">
	                                        <th scope="row">{{$i++}}</th>
	                                        <td>{{$zone->subdomain}}</td>
	                                        <td>{{$zone->pointed_to}}</td>
	                                        <td>{{$zone->created_at->diffForHumans()}}</td>
	                                        <td>
	                                        	<button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Records" onclick="deleteRecord({{$zone->id}})"><i class="material-icons">delete</i></button>
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
@endsection