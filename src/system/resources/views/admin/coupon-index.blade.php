@extends('layouts.master')
@section('title', 'Admin Panel - Dashboard')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>COUPON GIFT</h2>
    </div>
    <!-- End Title Page Section -->


    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        COUPON CODE
                    </h2>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#home_with_icon_title" data-toggle="tab" id="used">
                                 USED <span class="badge">{{$reedemed->count()}}</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#profile_with_icon_title" data-toggle="tab" id="unused">
                                 UN USED <span class="badge" id="badge-unreedemed">{{$unreedemed->count()}}</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                            
                            @if($reedemed->count() < 1)
                            	<h1 class="text-center">NO COUPON FOUND</h1>
                            @else
	                            
                            	<div class="table-responsive">
                            		<table class="table" id="used-coupon">
                            			<thead>
                            				<tr>
                            					<th>#</th>
                            					<th>CODE</th>
                            					<th>AMOUNT</th>
                            					<th>MESSAGE</th>
                            					<th>REEDEMED BY</th>
                            					<th>CREATED AT</th>
                            				</tr>
                            			</thead>
                            			<tbody>
                            				<?php $i = 1; ?>
                            				@foreach($reedemed as $reedem)
												<tr>
                            						<td>{{$i++}}</td>
                            						<td>{{$reedem->code}}</td>
                            						<td>{{$reedem->amount}}</td>
                            						<td>{{str_limit($reedem->messages,20)}}</td>
                            						<td>{{$reedem->reedemed_by}}</td>
                            						<td>{{$reedem->created_at->format('d/m/Y')}}</td>
                            					</tr>
                            				@endforeach
                            			</tbody>
                            		</table>
                            </div>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                            @if($unreedemed->count() < 1)
                                <h1 class="text-center">NO COUPON FOUND</h1>
                                <div class="text-center">
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#myModal">ADD NEW</button>                            
                                </div>
                            @else
                                
                                <div class="table-responsive">
                                    <table class="table" id="unused-coupon">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>CODE</th>
                                                <th>AMOUNT</th>
                                                <th>MESSAGE</th>
                                                <th>CREATED AT</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($unreedemed as $reedem)
                                                <tr id="row-{{$reedem->id}}">
                                                    <td>{{$reedem->id}}</td>
                                                    <td>{{$reedem->code}}</td>
                                                    <td>{{$reedem->amount}}</td>
                                                    <td>{{str_limit($reedem->messages,20)}}</td>
                                                    <td>{{$reedem->created_at->diffForHUmans()}}</td>
                                                    <td><button onclick="removeCoupon({{$reedem->id}})" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Coupon"><i class="material-icons">delete</i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                <div class="col-lg-12">
                                    <button class="btn btn-primary pull-right push-right" data-toggle="modal" data-target="#myModal">ADD NEW</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">CREATE NEW COUPON</h4>
	      </div>
	      <div class="modal-body">
	      	<hr />
	      	<form id="generate-coupon" method="post">
                {{csrf_field()}}

                <div class="row clearfix">
                    <div class="col-sm-12 col-lg-8">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" placeholder="Coupon Code" id="coupon-code" name="coupon_code" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                       <button class="btn btn-primary" style="width:100%;" onclick="generateCoupon();">GENERATE</button>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="amount" required>
                                <label class="form-label">Amount</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="form-group">
                            <div class="form-line">
                                <textarea rows="4" class="form-control no-resize" name="message" placeholder="Message if code reedemed successfully." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="submit" id="btn-generate-coupon"  style="width: 100%;" class="btn btn-success text-center" onclick="generateCouponCode()">GENERATE</button>
                    </div>
                </div>    
            </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>

	  </div>
	</div>
@endsection