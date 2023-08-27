@extends('layouts.master')
@section('title', 'Reseller Panel - Dashboard')
@section('body')

	<!-- Title Page Section -->
	<div class="block-header">
        <h2>DASHBOARD</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Widget Section -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">BALANCE</div>
                    <div class="number count-to" data-from="0" data-to="{{$user->balance}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">language</i>
                </div>
                <div class="content">
                    <div class="text">DNS CREATED</div>
                    <div class="number count-to" data-from="0" data-to="{{$dnss->count()}}" data-speed="1000" data-fresh-interval="20"></div>
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
                    <div class="number count-to" data-from="0" data-to="{{($ssh_inactive->count() && $vpn_inactive->count() == 0) ? 0 : $ssh_inactive->count() +  $vpn_inactive->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Widget Section -->


    <!-- SSH Account List Section -->
    <div class="row clearfix">
        <!-- Task Info -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>REEDEM GIFT CODE</h2>
                </div>
                <div class="body">
                    <div id="gift-result">
                        
                    </div>
                    <div class="row clearfix">
                        <form id="reedem" method="post" action="reedem">
                            {{csrf_field()}}
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input name="code" type="text" class="form-control">
                                        <label class="form-label">Code</label>
                                    </div>
                                </div>

                                <button id="btn-reedem-code" class="btn btn-success" type="submit" onclick="reedem()">REEDEM</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>QUICK CREATE SSH ACCOUNT</h2>
                </div>
                <div class="body">
                <div id="result">
                    
                </div>
                <form method="post" action="/vpn/create" id="create-ssh">

                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

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

                        <div class="col-sm-12 col-lg-12">
                            <select class="form-control show-tick" name="_server">
                                @if($servers->count() < 1)
                                    <option>NO SERVER FOUND</option>
                                @else
                                    <option>-- SLEECT SERVER --</option>
                                    @foreach($servers as $server)
                                        <option value="{{$server->ip}}" {{($server->type == 'vpn') ? 'disabled' : ''}}>{{$server->ip}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-12 col-lg-12">
                            {!! captcha_img() !!}
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="captcha" type="text" class="form-control">
                                    <label class="form-label">Captcha</label>
                                </div>
                            </div>
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

    </div>
    <!-- End SSH Account List Section -->
@endsection