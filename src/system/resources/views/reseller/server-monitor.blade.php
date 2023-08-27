
	<div class="block-header">
        <h2>MONITOR SERVER</h2>
    </div>

    @if(isset($error))
    	<div class="row clearfix">
    		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    			<div class="alert alert-danger">
    				No server found with IP <code>{{$_GET['server']}}</code>, Maybe typo or something?
    			</div>
    		</div>
    	</div>
	@endif

	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<div id="result"></div>
		</div>
	</div>

	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2 class="text-center">
	                    SELECT SERVER
	                </h2>
	            </div>
	            <div class="body">
	            	<form method="get" action="{{url('/server/monitor')}}">
		            	<div class="row clearfix">
		                    <div class="col-sm-6 col-lg-12">
		                        <select class="form-control show-tick" name="server">
		                            @if(isset($servers))
		                            	@if($servers->count() < 1)
		                            		<option value="">-- No Server Found --</option>
		                            	@else
		                            		<option value="{{(isset($_GET['server']) && $_GET['server'] != '' && !isset($error)) ? $_GET['server'] : '-- Select Server --'}}">{{(isset($_GET['server']) && $_GET['server'] != '' && !isset($error)) ? $_GET['server'] : '-- Select Server --'}}</option>
		                            		@foreach($servers as $server)
		                            			<option value="{{$server->ip}}">{{$server->ip}}</option>
		                        			@endforeach
		                        		@endif
		                        	@else
		                            	<option value="">-- No Server Found --</option>
		                            @endif
		                        </select>
		                    </div>
		                </div>
		                <hr />
		                <button class="btn bg-teal text-center" style="width:100%;">SELECT</button>
	            	</form>
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-{{$dropbear == 1 ? 'green' : ($dropbear == 2 ? 'orange' : 'red')}}">
                    <h2 class="text-center">
                        L2TP - <span id="dropbear_status">{{$dropbear == 1 ? 'ONLINE' : ($dropbear == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span>
                    </h2>
                </div>
                <div class="body">
                	<h1 class="text-center"><span id="dropbear_status">{{$dropbear == 1 ? 'ONLINE' : ($dropbear == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span></h1>
                	<hr />
                	<button class="btn btn-success" {{($dropbear == 2) ? '' : "disabled"}} id="btn-repair-dropbear" onclick="repairDropbear('{{$ip}}')" data-toggle="tooltip" data-placement="top" =" title="Repair Dropbear">REPAIR</button>
                	<button class="btn btn-warning" {{($dropbear == 1) ? '' : "disabled"}} id="btn-test-dropbear" onclick="testDropbear('{{$ip}}')" data-toggle="tooltip" data-placement="top" =" title="Test Dropbear Services">TEST</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-{{$openvpn == 1 ? 'green' : ($openvpn == 2 ? 'orange' : 'red')}}">
                    <h2 class="text-center">
                        OPENVPN - <span id="dropbear_status">{{$openvpn == 1 ? 'ONLINE' : ($openvpn == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span>
                    </h2>
                </div>
                <div class="body">
                	<h1 class="text-center"><span id="dropbear_status">{{$openvpn == 1 ? 'ONLINE' : ($openvpn == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span></h1>
                	<hr />
                	<button class="btn btn-success" {{($openvpn == 2) ? '' : 'disabled'}} id="btn-repair-openvpn" onclick="repairOpenVPN('{{$ip}}')" data-toggle="tooltip" data-placement="top" title="Repair OpenVPN">REPAIR</button>
                	<button class="btn btn-warning" {{($openvpn == 1) ? '' : 'disabled'}} id="btn-test-openvpn" onclick="testOpenVPN('{{$ip}}')" data-toggle="tooltip" data-placement="top" title="Test OpenVPN">TEST</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-{{$squid == 1 ? 'green' : ($squid == 2 ? 'orange' : 'red')}}">
                    <h2 class="text-center">
                        SQUID - <span id="dropbear_status">{{$squid == 1 ? 'ONLINE' : ($squid == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span>
                    </h2>
                </div>
                <div class="body">
                	<h1 class="text-center"><span id="dropbear_status">{{$squid == 1 ? 'ONLINE' : ($squid == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span></h1>
                	<hr />
                	<button class="btn btn-success" {{($squid == 2) ? '' : "disabled"}} id="btn-repair-squid" onclick="repairSquid('{{$ip}}')" data-toggle="tooltip" data-placement="top" title="Repair Squid">REPAIR</button>
                	<button class="btn btn-warning" {{($squid == 1) ? '' : "disabled"}} id="btn-test-squid" onclick="testSquid('{{$ip}}')" data-toggle="tooltip" data-placement="top" title="Test Squid Service">TEST</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-{{$badvpn == 1 ? 'green' : ($badvpn == 2 ? 'orange' : 'red')}}">
                    <h2 class="text-center">
                        BADVPN - <span id="dropbear_status">{{$badvpn == 1 ? 'ONLINE' : ($badvpn == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span>
                    </h2>
                </div>
                <div class="body">
                	<h1 class="text-center"><span id="dropbear_status">{{$badvpn == 1 ? 'ONLINE' : ($badvpn == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span></h1>
                	<hr />
                	<button class="btn btn-success" disabled>REPAIR</button>
                	<button class="btn btn-warning" {{($squid == 1) ? '' : 'disabled'}} id="btn-test-badvpn" onclick="testBadVPN('{{$ip}}')" data-toggle="tooltip" data-placement="top" title="Test BadVPN">TEST</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-{{$openssh == 1 ? 'green' : ($openssh == 2 ? 'orange' : 'red')}}">
                    <h2 class="text-center">
                        OPENSSH - <span id="dropbear_status">{{$openssh == 1 ? 'ONLINE' : ($openssh == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span>
                    </h2>
                </div>
                <div class="body">
                	<h1 class="text-center"><span id="dropbear_status">{{$openssh == 1 ? 'ONLINE' : ($openssh == 2 ? 'OFFLINE' : 'UNKNOWN')}}</span></h1>
                	<hr />
                	<button class="btn btn-success" disabled>REPAIR</button>
                	<button class="btn btn-warning" disabled>TEST</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-{{$http == 1 ? 'green' : ($http == 2 ? 'orange' : 'red')}}">
                    <h2 class="text-center">
                        HTTP - <span id="dropbear_status">{{$http == 1 ? 'PASS' : ($http == 2 ? 'REFUSED' : 'ERROR')}}</span>
                    </h2>
                </div>
                <div class="body">
                	<h1 class="text-center"><span id="dropbear_status">{{$http == 1 ? 'PASS' : ($http == 2 ? 'REFUSED' : 'ERROR')}}</span></h1>
                	<hr />
                	<button class="btn btn-success" disabled>REPAIR</button>
                	<button class="btn btn-warning" disabled>TEST</button>
                </div>
            </div>
        </div>	
	</div>
