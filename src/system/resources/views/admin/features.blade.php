@extends('layouts.master')
@section('title', 'Admin Panel - Feature Management')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>LIST FEATURES</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Simple Widget -->
	<div class="row clearfix">

		<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
	    	<div id="result">

	    	</div>
	    </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            FEATURE MANAGEMENT
                            <small>Here you can enable & disable panel feature easily.</small>
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach(app('features')->getAll() as $feature)
                                    <tr id="row-{{$feature->id}}">
                                        <td>{{$i}}</td>
                                        <td> {{$feature->title}} </td>
                                        <td> {{$feature->description}} </td>
                                        <td> {!!$feature->status ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Inactive</label>'!!} </td>
                                        <td>
                                            @if($feature->status)
                                                <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Disable Feature" onclick="disableFeature({{$feature->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">block</i></button>
                                            @else
                                                <button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Enable Feature" onclick="enableFeature({{$feature->id}})" id="lock-account"><i class="material-icons" id="lock-account">check</i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

	</div>
    <!-- End Simple Widget -

@endsection