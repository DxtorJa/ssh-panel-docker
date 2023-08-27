@extends('layouts.master')
@section('title', 'Create New Tickets ')
@section('body')
	<div class="block-header">
        <h2>Create New Ticket</h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        TICKET DETAILS
                    </h2>
                </div>
                <div class="body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h4>Please Fix The Following Errors.</h4>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif
                	<form method="post" id="add-ticket">
                		{{csrf_field()}}
                		<div class="row clearfix">
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <input type="text" class="form-control" name="subject" required>
	                                    <label class="form-label">Subject</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-6">
                                <p>
                                    <b>Category</b>
                                </p>
	                            <select class="form-control show-tick" name="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <p>
                                    <b>Priority</b>
                                </p>
	                            <select class="form-control show-tick" name="priority">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
	                        </div>
	                        <div class="col-sm-12">
	                            <div class="form-group form-float">
	                                <div class="form-line">
	                                    <textarea rows="4" type="text" class="form-control" name="message"></textarea>
	                                    <label class="form-label">Message</label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-12 col-sm-12">
	                        	<button type="submit" class="btn btn-success pull-right" id="btn-add-reseller">CREATE</button>
	                        </div>
	                    </div>
                	</form>
                </div>
            </div>
        </div>
    
@endsection