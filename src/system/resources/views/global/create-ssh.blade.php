@extends('layouts.master')
@section('title', 'Create SSH - ' . $server->ip)
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>CREATE SSH</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Simple Widget -->
	<div class="row clearfix">

		<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
	    	<div id="result">

	    	</div>
	    </div>

        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    	CREATE SSH ON SERVER {{$server->ip}}
                    </h2>
                </div>
                <div class="body">
                	<form method="post" action="/ssh/create" id="create-ssh">

                        	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                        	<input type="hidden" name="_server" id="_server" value="{{$server->ip}}">

                        	<div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input name="username" type="text" class="form-control">
                                            <label class="form-label">User</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input name="password" type="password" class="form-control">
                                            <label class="form-label">Password</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" rows="3" name="note"></textarea>
                                            <label class="form-label">Notes</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-12">
                                	<select class="form-control show-tick" name="duration">
                                		<option value="-- Select Duration --">-- Select Duration --</option>
                                		<option value="trial">Trial</option>
                                		<option value="1">1 Month</option>
                                		<option value="2">2 Month</option>
                                		<option value="3">3 Month</option>
                                		<option value="4">4 Month</option>
                                		<option value="5">5 Month</option>
                                		<option value="6">6 Month</option>
                                		<option value="7">7 Month</option>
                                		<option value="8">8 Month</option>
                                		<option value="9">9 Month</option>
                                		<option value="10">10 Month</option>
                                		<option value="11">11 Month</option>
                                		<option value="12">12 Month</option>
                                	</select>
                                </div>

                                <div class="col-sm-12">
                                    <label>Choose how you pay : </label>
                                    <div class="demo-radio-button">
                                        <input name="pay" type="radio" id="radio_1" checked value="balance" />
                                        <label for="radio_1">Balance : ({{number_format($user->balance, 0 , '' , '.')}})</label>
                                        <input name="pay" type="radio" id="radio_2" {{($user->point == 0) ? 'disabled' : ''}} value="point" />
                                        <label for="radio_2">Point : ({{$user->point}})</label>
                                    </div>
                                </div>

                                <hr />

                                <div class="col-sm-12">
                                    <button onclick="createSSH()" type="submit" id="btn-create-ssh" class="btn bg-teal waves-effect">CREATE</button>
                                </div>
                            </div>
                    </form>
    			</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    	YOUR DETAILS
                    </h2>
                </div>
                <div class="body">
        			<ul class="list-group">
                        <li class="list-group-item">Balance <span class="badge bg-pink">{{number_format($user->balance, 0 , '' , '.')}}</span></li>
                        <li class="list-group-item">Point <span class="badge bg-purple">{{number_format($user->point, 0 , '' , '.')}}</span></li>
                        <li class="list-group-item">SSH User <span class="badge bg-teal"><span id="ssh-user">{{$ssh->count()}}</span> User created.</span></li>
                        <li class="list-group-item">VPN User <span class="badge bg-orange"><span id="vpn-user">{{$vpn->count()}}</span> User created.</span></li>
                    </ul>
    			</div>
			</div>
		</div>
	</div>
    <!-- End Simple Widget -->
@endsection
