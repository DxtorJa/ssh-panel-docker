@extends('layouts.master')
@section('title', 'Admin Panel - Editing Info ' . $post->title)
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>EDITING INFO</h2>
    </div>
    <!-- End Title Page Section -->

    <form method="post" action="/info/edit">
    	
    	{{csrf_field()}}
    	<input type="hidden" name="slug" value="{{$post->slug}}">
    	<input type="hidden" name="posted" value="{{$post->posted_by}}">
    	<div class="row clearfix">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="card">
	                <div class="body">
						<input type="text" class="form-control" placeholder="TITLE" name="title" value="{{$post->title}}">                        
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
	            <textarea id="editor" name="body">
	            	{{$post->body}}
	            </textarea>
	        </div>

	        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	            <div class="card">
	            	<div class="header">
	            		<h2>
	            			Post Details
	            		</h2>
	            	</div>
	                <div class="body">
		                <p>Status: {!!($post->status == 'unpublished') ? '<span class="badge bg-orange">' . $post->status . '</span>' : '<span class="badge bg-green">' . $post->status . '</span>'!!}</p>
		                <p>URL: <a href="{{$site_setting->site_url . '/info/' . $post->slug}}">{{$site_setting->site_url . '/info/' . $post->slug}}</a></p>
		                <p>Created At: {{$post->created_at->diffForHumans()}}</p>
		                <p>Created By: {{$post->posted_by}}</p>
		                <button class="btn btn-primary" type="submit">SAVE</button>
	                </div>
	            </div>
	        </div>
	    </div>
    </form>

@endsection