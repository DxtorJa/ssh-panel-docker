@extends('layouts.master')
@section('title', 'Admin Panel - Reseller List')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST RESELLER</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        LIST RESELLER
                    </h2>
                </div>
                <div class="body">
                	@if($resellers->count() < 1)
                		<h1 class="text-center">NO RESELLER FOUND</h1>
                	@else
	                	<div class="table-responsive">
	                		<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        <th>BALANCE</th>
                                        <th>CREATED AT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php $i = 1; ?>
                                    @foreach($resellers as $zone)
                                    	<tr id="row-{{$zone->id}}">
	                                        <th scope="row">{{$i++}}</th>
	                                        <td>{{$zone->name}}</td>
                                            <td>{{$zone->email}}</td>
	                                        <td>{{$zone->balance}}</td>
	                                        <td>{{$zone->created_at->format('d/m/Y')}}</td>
	                                        <td>
                                                <button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Records" onclick="deleteReseller({{$zone->id}})"><i class="material-icons">delete</i></button>
	                                        	<button class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Reseller" onclick="editReseller({{$zone->id}})"><i class="material-icons">build</i></button>
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

    <div id="editResellerModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">EDIT RESELLER</h4>
          </div>
          <div class="modal-body" id="reseller-edit-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
          </div>
        </div>

      </div>
    </div>
@endsection