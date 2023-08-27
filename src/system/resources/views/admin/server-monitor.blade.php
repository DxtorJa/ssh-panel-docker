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
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">memory</i>
                </div>
                <div class="content">
                    <div class="text">RAM {{isset($rambytes) ? '(' . $rambytes . ')' : ''}}</div>
                    <div class="number count-to" data-from="0" data-to="{{isset($ram) ? $ram : 0}}" data-speed="1000" data-fresh-interval="20" value="1" data-toggle="tooltip" title="20GB"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box bg-brown hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">storage</i>
                </div>
                <div class="content">
                    <div class="text">DISK SIZE {{isset($diskbytes) ? '(' . $diskbytes . ')' : ''}}</div>
                    <div class="number count-to" data-from="0" data-to="{{isset($disk) ? $disk : 0}}" data-speed="1000" data-fresh-interval="20" value="0">0</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box bg-red hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">dns</i>
                </div>
                <div class="content">
                    <div class="text">NUMBER OF CPU'S</div>
                    <div class="number count-to" data-from="0" data-to="{{isset($cpu) ? $cpu : 0}}" data-speed="1000" data-fresh-interval="20" value="0">0</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">router</i>
                </div>
                <div class="content">
                    <div class="text">NETWORK</div>
                    <div class="number count-to" data-from="0" data-to="{{isset($network) ? $network : 0}}" data-speed="1000" data-fresh-interval="20" value="0">0</div>
                </div>
            </div>
        </div>
    </div>


	<div class="row clearfix">
	    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2 class="text-center">
	                    SYSTEM INFORMATION
	                </h2>
	            </div>
	            <div class="body">
	            	<ul class="list-group">
                        <li class="list-group-item">Hostname <span class="badge bg-pink"><div id="hostname" data-toggle="tooltip" data-placement="top" title="{{isset($hostname) ? $hostname : 'unknown'}}">{{isset($hostname) ? str_limit($hostname,20) : 'unknown'}}</div></span></li>
                        <li class="list-group-item">IP Address <span class="badge bg-cyan"><div id="ip_address" data-toggle="tooltip" data-placement="top" title="{{isset($ip) ? $ip : 'unknown'}}">{{isset($ip) ? $ip : 'unknown'}}</div></span></li>
                        <li class="list-group-item">Kernel <span class="badge bg-teal"><div id="kernel" data-toggle="tooltip" data-placement="top" title="{{isset($kernel) ? $kernel : 'unknown'}}">{{isset($kernel) ? str_limit($kernel,20) : 'unknown'}}</div></span></li>
                        <li class="list-group-item">Distro <span class="badge bg-red"><div id="distro" data-toggle="tooltip" data-placement="top" title="{{isset($distro) ? $distro : 'unknown'}}">{{isset($distro) ? str_limit($distro,20) : 'unknown'}}</div></span></li>
                        <li class="list-group-item">Uptime <span class="badge bg-orange"><div id="uptime" data-toggle="tooltip" data-placement="top" title="{{isset($uptime) ? gmdate('H', $uptime) . ' Hours ' . gmdate('i', $uptime) . ' minutes' : 'unknown'}}">{{isset($uptime) ? gmdate('H', $uptime) . ' Hours ' . gmdate('i', $uptime) . ' minutes' : 'unknown'}}</div></span></li>
                        <li class="list-group-item">Users <span class="badge bg-brown"><div id="users" data-toggle="tooltip" data-placement="top" title="{{isset($users) ? $users : 'unknown'}}">{{isset($users) ? $users : 'unknown'}}</div></span></li>
                        <li class="list-group-item">Encoding <span class="badge bg-purple"><div id="encoding" data-toggle="tooltip" data-placement="top" title="{{isset($encoding) ? $encoding : 'unknown'}}">{{isset($encoding) ? $encoding : 'unknown'}}</div></span></li>
                        <li class="list-group-item">Proccess <span class="badge bg-blue"><div id="proccess" data-toggle="tooltip" data-placement="top" title="{{isset($proccess) ? $proccess : 'unknown'}}">{{isset($proccess) ? str_limit($proccess,20) : 'unknown'}}</div></span></li>
                    </ul>
	            </div>
	        </div>
	        <div class="card">
	            <div class="header">
	                <h2 class="text-center">
	                    SYSTEM USAGE
	                </h2>
	            </div>
	            <div class="body">
	            	<ul class="list-group">
                        <li class="list-group-item"> 
                        	RAM <span class="badge bg-pink"><div id="ram_usage">{{isset($ram_used) ? $ram_used : '0b'}}/{{isset($ram_total) ? $ram_total : '0b'}}</div></span>
                        	<hr />
                        	<div class="progress">
                                <div class="progress-bar bg-pink progress-bar-striped active" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"
                                     style="width: {{isset($ram_percent) ? $ram_percent : 0}}%">
                                    {{isset($ram_percent) ? $ram_percent : 0}}%
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                        	<h4 class="text-center">STORAGE</h4>
                        	<hr />
                 			@if(isset($disks))
                 				@foreach($disks as $storage)
	                        		<?php $r = (array)$storage; ?>
	                        		<p class="text-center"><code>{{$r['@attributes']->MountPoint}}</code></p>
		                        	<div class="progress">
		                                <div class="progress-bar bg-green progress-bar-striped active" style="width: {{\App\Http\Controllers\ServerController::percent($r['@attributes']->Total,$r['@attributes']->Used)}}%" data-toggle="tooltip" data-placement="top" title="Free ({{\App\Http\Controllers\ServerController::bytes($r['@attributes']->Free)}}, {{\App\Http\Controllers\ServerController::percent($r['@attributes']->Total,$r['@attributes']->Used)}}%)">
		                                    Free ({{\App\Http\Controllers\ServerController::bytes($r['@attributes']->Free)}}, {{\App\Http\Controllers\ServerController::percent($r['@attributes']->Total,$r['@attributes']->Used)}}%)
		                                </div>
		                                <div class="progress-bar bg-red progress-bar-striped active" style="width: {{$r['@attributes']->Percent}}%" data-toggle="tooltip" data-placement="top" title="Used ({{\App\Http\Controllers\ServerController::bytes($r['@attributes']->Used)}},{{$r['@attributes']->Percent}}%)">
		                                    Used ({{\App\Http\Controllers\ServerController::bytes($r['@attributes']->Used)}},{{$r['@attributes']->Percent}}%)
		                                </div>
		                            </div>
		                        @endforeach
                 			@endif
                        </li>
					</ul>
	            </div>
	        </div>
	   	</div>
	    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
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
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header bg-indigo">
                    <h2 class="text-center">
                        NETWORK
                    </h2>
                </div>
                <div class="body">
                	<div class="body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Interface</th>
                                    <th>RxBytes</th>
                                    <th>TxBytes</th>
                                    <th>Error/Drop</th>
                                    <th>Info</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                			@foreach($networks as $net)
                				<?php $r = (array)$net; ?>
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{@$r['@attributes']->Name}}</td>
                                    <td>{{@\App\Http\Controllers\ServerController::bytes($r['@attributes']->RxBytes)}}</td>
                                    <td>{{@\App\Http\Controllers\ServerController::bytes($r['@attributes']->TxBytes)}}</td>
                                    <td>{{@$r['@attributes']->Err}}/{{$r['@attributes']->Drops}}</td>
                                    <td>{{@$r['@attributes']->Info}}</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
	
	</div>