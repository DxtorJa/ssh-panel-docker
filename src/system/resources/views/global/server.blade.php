@extends('layouts.master')
@section('title', Auth::user()->isAdmin() ? 'Admin Panel' : 'Reseller Panel')
@section('admin-sidebar')
	@parent
	
@endsection