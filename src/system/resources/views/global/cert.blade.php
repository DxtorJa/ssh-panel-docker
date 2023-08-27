@extends('layouts.master')
@section('title', 'Download VPN Certificate')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>CHOOSE CERTIFICATE</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Simple Widget -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                            CHOOSE CERTIFICATE
                    </h2>
                </div>
                <div class="body">
                    @if($certs->count() < 1)
                        <h1 class="text-center">NO CERTIFICATE AVAILABLE</h1>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SERVER IP</th>
                                        <th>SERVER NAME</th>
                                        <th>PORT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($certs as $cert)
                                        <tr id="row-{{$cert->id}}">
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{server($cert->server_id)->ip}}</td>
                                            <td>{{server($cert->server_id)->name}}</td>
                                            <td>{{$cert->port}}</td>
                                            <td>
                                                <a href="{{$cert->url}}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Download"><i class="material-icons">file_download</i></a>
                                                @if(Auth::user()->role == 'admin')
                                                <button onclick="removeCert('{{$cert->id}}')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove Certificate"><i class="material-icons">delete</i></button>
                                                @endif
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
    <!-- End Simple Widget -->

@endsection