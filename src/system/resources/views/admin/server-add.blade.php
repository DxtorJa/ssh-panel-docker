@extends('layouts.master')
@section('title', 'Admin Panel - Add Server')
@section('body')

	<div class="block-header">
        <h2>ADD SERVER</h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    ADD NEW SERVER
                    </h2>
                </div>
                <div class="body">
                <form method="post" action="/deposit" id="addserver">

                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

                    <div class="row clearfix">

                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="server_name" type="text" class="form-control">
                                    <label class="form-label">Server Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="ip_address" type="text" class="form-control">
                                    <label class="form-label">IP Address</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="user" type="text" class="form-control">
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
                                    <input name="country" type="text" class="form-control">
                                    <label class="form-label">Country</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" id="service">
                            <select class="form-control show-tick" name="service_type" id="service_type">
                                <option value="">-- VPN Type --</option>
                                <option value="l2tp">L2TP/IPSec</option>
                                <option value="ovpn">OpenVPN</option>
                            </select>
                        </div>
                        <div class="col-sm-12" id="ipsec" style="display: none;">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="ipsec_psk" type="text" class="form-control">
                                    <label class="form-label">IPSec PSK</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="limit_day" type="text" class="form-control">
                                    <label class="form-label">Limit/day (Daily limit)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="points" type="text" class="form-control">
                                    <label class="form-label">Points/create (Points per create 1 account), EX: 1</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="price" type="text" class="form-control">
                                    <label class="form-label">Price</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="price_point" type="text" class="form-control">
                                    <label class="form-label">Price by Point (price if user buy with his point)</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr />

                        <div class="col-sm-12">
                            <button onclick="addserver()" id="btn-add-server" class="btn bg-teal waves-effect">ADD</button>
                        </div>

                         </div>
                        </form>
                    </div>
                </div>
            </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            INSTRUCTION
                        </h2>
                    </div>
                    <div class="body">
                        <h4>Before you add server.</h4>
                        <div class="alert alert-info">
                            This app using <a style="color: #fff;" href="http://phpsysinfo.github.io/phpsysinfo/">phpsysinfo</a> to monitoring the server, so this app is depends to that application,
                            Server will run without phpsysinfo, but the monitoring system will not work so run command below.
                        </div>
                        <h4>Debian & Ubuntu Server.</h4>
                        <hr />
                        <script src="https://gist.github.com/sshpanel/159f5863a9886ae83c1f0627c53f6d6d.js"></script>
                        
                        <div class="alert alert-warning">
                            In order to able to use L2TP Service, you need to run command below, (ONLY UBUNTU & CENTOS SERVER).
                        </div>
                        <script src="https://gist.github.com/sshpanel/df739c24f0e3266041a378479e8c9b6a.js"></script>
                        <br />
                        <h4>CentOS</h4>
                        <hr />
                        <div class="alert alert-warning">CentOS Server will be added soon.</div>
                        <hr />                        
                        <div class="alert alert-info">
                            After running command above, validate the installation by visiting <code>http://your-server-ip:4210</code> this will show the phpsysinfo interface.
                        </div>
                    </div>
                </div>
        </div>
    </div>

@endsection

@section('js')

<script type="text/javascript">
    
    $(document).ready(function() {

        $('#service').on('change', function(e) {

            var _ = $(this);

            if(_.val() == 'l2tp') {
                $('#ipsec').fadeIn('slow');
            }
            else if(_.val() == 'both') {
                $('#ipsec').fadeIn('slow');
            }
            else 
            {
                $('#ipsec').toggle();
            }

        });

    });

</script>


@endsection