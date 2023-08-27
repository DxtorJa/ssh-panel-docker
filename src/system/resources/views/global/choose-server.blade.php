@extends('layouts.master')
@section('title', 'Create SSH Account')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>SELECT SERVER</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Simple Widget -->
    <div class="row clearfix">
        @if($servers->count() < 1)
        	<h1 class="text-center">NO SERVER AVAILABLE</h1>
        @else
        	@foreach($servers as $server)
        		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header bg-green">
                            <h2 class="text-center">
                            	{{strtoupper($server->name)}}
                            </h2>
                        </div>
                        <div class="body">
                        	<p class="text-center"><strong>IP Address: {{$server->ip}}</strong></p>
                            <hr />
                            <p class="text-center"><strong>Country: {{$server->country}}</strong></p>
                            <hr />
                            <p class="text-center"><strong>Services: {{$server->type}}</strong></p>
                            <hr />
                            <p class="text-center"><strong>Limit/day: {{$server->limit_day}}</strong></p>
                            <hr />
                            <p class="text-center"><strong>Prices: {{$server->price}}</strong></p>
                            <hr />
                        	<a class="btn bg-green" style="width: 100%;" href="/{{$server->type}}/create/{{$server->ip}}">Create</a>
                        </div>
                    </div>
                </div>
        	@endforeach
        @endif
	</div>
    <!-- End Simple Widget -->

@endsection