@extends('layouts.master')
@section('title', 'Admin Panel - Dashboard')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>ADMIN DASHBOARD</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Widget Section -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">group</i>
                </div>
                <div class="content">
                    <div class="text">RESELLER</div>
                    <div class="number count-to" data-from="0" data-to="{{$resellers->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">feedback</i>
                </div>
                <div class="content">
                    <div class="text">TICKETS</div>
                    <div class="number count-to" data-from="0" data-to="{{$tickets->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">dns</i>
                </div>
                <div class="content">
                    <div class="text">SERVER</div>
                    <div class="number count-to" data-from="0" data-to="{{$servers->count()}}" data-speed="15" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-deep-purple hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">list</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL ACCOUNT</div>
                    <div class="number count-to" data-from="0" data-to="{{$vpns->count() + $sshs->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <div class="content">
                    <div class="text">VPN ACCOUNT</div>
                    <div class="number count-to" data-from="0" data-to="{{$vpns->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">cloud</i>
                </div>
                <div class="content">
                    <div class="text">SSH ACCOUNT</div>
                    <div class="number count-to" data-from="0" data-to="{{$sshs->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-purple hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">check</i>
                </div>
                <div class="content">
                    <div class="text">ACCOUNT ACTIVE</div>
                    <div class="number count-to" data-from="0" data-to="{{$ssh_active->count() + $vpn_active->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">cancel</i>
                </div>
                <div class="content">
                    <div class="text">ACCOUNT EXPIRED</div>
                    <div class="number count-to" data-from="0" data-to="{{($ssh_inactive->count() + $vpn_inactive->count())}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Widget Section -->

    <!-- Simple Widget -->
    	<div class="row clearfix">

            <!-- Colorful Panel Items With Icon -->
            {{--  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                        	COUPON GENERATOR
                        </h2>
                    </div>
                    <div class="body">
                        <form method="post" action="/coupon" id="coupon">

                        	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

                        	<div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input name="amount" type="text" class="form-control">
                                            <label class="form-label">Amount</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="messages" rows="4" class="form-control no-resize" placeholder="Messages if code reedemed successfully"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr />

                                <div class="col-sm-12">
                                	<button onclick="generateGiftCode()" id="btn-generate-coupon" class="btn bg-teal waves-effect">GENERATE</button>
                                </div>

                            </div>
                        </form>
        			</div>
    			</div>
			</div>  --}}
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                        	QUICK DEPOSIT
                        </h2>
                    </div>
                    <div class="body">
                        <form method="post" action="/deposit" id="deposit">

                        	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

                        	<div class="row clearfix">
                                <div class="col-sm-12">
                                    <select class="form-control show-tick" name="reseller">
                                        @if($resellers->count() < 1)
                                            <option value="">-- Reseller Not Found --</option>
                                        @else
                                            <option value="">-- Select Reseller --</option>
                                            @foreach($resellers as $reseller)
                                                <option value="{{$reseller->email}}">{{$reseller->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input name="amount" type="text" class="form-control">
                                            <label class="form-label">Amount</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr />

                                <div class="col-sm-12">
                                	<button onclick="deposit()" id="btn-quick-deposit" class="btn bg-teal waves-effect">DEPOSIT</button>
                                </div>

                            </div>
                        </form>
        			</div>
    			</div>
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            SERVER TABLES
                            <small>Basic details of server monitoring.</small>
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        @if($servers->count() < 1)
                            <h1 class="text-center">NO SERVER AVAILABLE</h1>
                        @else
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SERVER NAME</th>
                                    <th>SERVER IP</th>
                                    <th>SERVER USER</th>
                                    <th>SERVER TYPE</th>
                                    <th>SERVER DAILY</th>
                                    <th>SERVER ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($servers as $server)       
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$server->name}}</td>
                                        <td>{{$server->ip}}</td>
                                        <td>{{$server->user_created}}</td>
                                        <td><span class="badge bg-pink">{{($server->type == 'both') ? 'SSH & VPN' : $server->type}}</span></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {{round($server->user_created / $server->limit_day * 100)}}%">
                                                    {{round($server->user_created / $server->limit_day * 100)}}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-danger"><i class="material-icons">delete</i></button>
                                            <button class="btn btn-xs btn-primary"><i class="material-icons">check</i></button>
                                            <button class="btn btn-xs btn-warning"><i class="material-icons">remove_red_eye</i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
		</div>
    <!-- End Simple Widget -->

@endsection
