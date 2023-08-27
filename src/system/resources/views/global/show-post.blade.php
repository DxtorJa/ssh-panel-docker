@extends('layouts.master')
@section('title', $post->title)
@section('body')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-sm-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="header">
					<h2>
						{{$post->title}}	
					</h2>
					<small><i>Posted by:  {{$post->posted_by}} | Posted at:  {{$post->created_at->diffForHumans()}}</i></small>
				</div>
				<div class="body">
					{!! $post->body !!}
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-sm-12">
			<div class="body">
			<div class="fb-comments" data-href="{{$site_setting->site_url . '/info/' . $post->slug}}" data-numposts="10" data-width="100%"></div>
			</div>
		</div>
	</div>	

@endsection