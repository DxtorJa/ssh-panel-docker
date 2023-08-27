@extends('layouts.master')
@section('title', 'Admin Panel - Add Reseller')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>ADD NEW RESELLER</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        NEW RESELLER DETAILS
                    </h2>
                </div>
                <div class="body">
                	<form method="post" id="add-reseller">
                		{{csrf_field()}}
                		<div class="row clearfix">
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="username" required>
	                                    <label class="form-label">Username</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="email" class="form-control" name="email" required>
	                                    <label class="form-label">Email</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="balance" required>
	                                    <label class="form-label">Balance</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="password" class="form-control" name="password" required>
	                                    <label class="form-label">Password</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-12 col-sm-12">
	                        	<button class="btn btn-success pull-right" onclick="addReseller();" id="btn-add-reseller">CREATE</button>
	                        </div>
	                    </div>
                	</form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        EXISTING RESELLER
                    </h2>
                </div>
                <div class="body">
                	@if($resellers->count() < 1)
                		 <h1 class="text-center">NO RESELLER</h1>
                	@else
                		<ul class="list-group">
	                		<?php $i = 1; ?>
	                		@foreach($resellers as $reseller)
	                                <li class="list-group-item">
	                                	<h4 class="text-center">{{strtoupper($reseller->name)}}</h4>
	                                	<hr />
	                                	Email <span class="badge bg-cyan">{{$reseller->email}}</span>
	                                	<br>
	                                	<br>
	                                	Balance <span class="badge bg-teal">{{$reseller->balance}}</span>
	                                	<hr />
	                                	<button class="btn btn-warning " data-toggle="tooltip" data-placement="top" title="Add Balance" onclick="addBalance({{$reseller->id}})">Add Balance</button>
	                                	<button class="btn btn-danger " data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteReseller({{$reseller->id}})">Delete</button>
	                                	<hr />
	                                </li>
	                            <?php $i++; ?>
	                            @if($i >= 4)
	                            	<hr />
	                            	<a href="/reseller/list" class="btn btn-primary text-center" style="width: 100%;">SHOW ALL</a>
	                            	<?php break; ?>
	                            @endif
	                		@endforeach
	                	</ul>
                	@endif
                </div>
            </div>
        </div>
    </div>

@endsection