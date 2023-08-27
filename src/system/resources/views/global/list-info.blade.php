@extends('layouts.master')
@section('title', 'List Info')
@section('body')
	
	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST INFO</h2>
    </div>
    <!-- End Title Page Section -->

    <div class="row clearfix">
    	<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
    		<div class="card">
    			<div class="header">
    				<h2>
    					LIST INFO
    				</h2>
    			</div>
    			<div class="body">
    				@if($posts->count() < 1)
    					<h1 class="text-center">NO INFORMATION FOUND</h1>
    				@else
    					<div class="table-responsive">
    						<table class="table">
    							<thead>
    								<tr>
    									<th>#</th>
    									<th>TITLE</th>
    									<th>BODY</th>
    									<th>CREATED AT</th>
    									<th>ACTION</th>
    								</tr>
    							</thead>
    							<tbody>
    								<?php $i = 1; ?>
    								@foreach($posts as $post)
    									<tr id="row-{{$post->id}}">
    										<td>{{$i}}</td>
    										<td>{{$post->title}}</td>
    										<td>{{str_limit(strip_tags($post->body),20)}}</td>
    										<td>{{$post->created_at->diffForHumans()}}</td>
    										<td>
                                            <a href="/info/{{$post->slug}}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Show Post"><i class="material-icons">remove_red_eye</i></a>
    										</td>
    									</tr>
    									<?php $i++; ?>
    								@endforeach
    							</tbody>
    						</table>
    						@endif
    					</div>
    			</div>
    		</div>
    	</div>
    </div>

@endsection