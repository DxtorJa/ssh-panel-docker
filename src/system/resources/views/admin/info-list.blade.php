@extends('layouts.master')
@section('title', 'Admin Panel - List Info')
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
    					<h1 class="text-center">NO POST FOUND</h1>
    				@else
    					<div class="table-responsive">
    						<table class="table">
    							<thead>
    								<tr>
    									<th>#</th>
    									<th>TITLE</th>
    									<th>BODY</th>
    									<th>SLUG</th>
    									<th>STATUS</th>
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
    										<td>{{$post->slug}}</td>
    										<td>{!!($post->status == 'unpublished') ? '<span class="badge bg-orange">' . $post->status . '</span>' : '<span class="badge bg-green">' . $post->status . '</span>'!!}</td>
    										<td>{{$post->created_at->format('d/m/Y')}}</td>
    										<td>
    											<button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Info" onclick="deleteInfo({{$post->id}})"><i class="material-icons">delete</i></button>
                                                <button class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit Info" onclick="editInfo({{$post->id}})"><i class="material-icons">edit</i></button>
                                                @if($post->status == 'unpublished')
                                                    <button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Publish Info" onclick="publishInfo({{$post->id}})"><i class="material-icons">check</i></button>
                                                @else
                                                    <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Unpublish Info" onclick="unpublishInfo({{$post->id}})"><i class="material-icons">cancel</i></button>
                                                @endif
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