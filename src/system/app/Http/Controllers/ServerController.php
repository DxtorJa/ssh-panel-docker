<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use App\Notif;
use App\Cert;
use Validator;
use Auth;
use phpseclib\Net\SSH2;
use GuzzleHttp\Client;
use App\VPNSoftware;

class ServerController extends Controller
{
    public function addNew()
    {
        $server = Server::get();
        return view('admin.server-add')->with('servers', $server);
    }

    public function create(Request $request)
    {
        $server = Server::where('ip', $request->ip_address)->first();
        if($server)
        {
            return response()->json([
                'status' => 'error',
                'data' => [
                    'reason' => 'server exists'
                ]
            ],500);
        }

        $validator = Validator::make($request->all(), [
            'server_name' => 'required',
            'ip_address' => 'required',
            'user' => 'required',
            'password' => 'required',
            'country' => 'required',
            'limit_day' => 'required',
            'points' => 'required',
            'price' => 'required',
            'service_type' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'data' => [
                    'reason' => 'some of field is error',
                    'errors' => $validator
                ]
            ],500);
        }

        // test server
        $ssh = new SSH2($request->ip_address);
        if(!$ssh->login($request->user,$request->password))
        {
            return response()->json([
                'status' => 'error',
                'data' => [
                    'reason' => 'can\'t connect to remote server',
                ]
            ],500);
        }

        $server = Server::create([
            'name' => $request->server_name,
            'ip' => $request->ip_address,
            'user' => $request->user,
            'pass' => encrypt($request->password),
            'country' => $request->country,
            'type' => 'vpn',
            'limit' => 0,
            'limit_day' => $request->limit_day,
            'user_created' => 0,
            'total_user' => 0,
            'points' => $request->points,
            'price' => $request->price,
            'price_point' => $request->price_point
        ]);

        Notif::create([
            'user_email' => Auth::user()->email,
            'message' => 'Server ' . $request->ip_address . ' successfully added!',
            'color' => 'bg-green',
            'icons' => 'dns',
            'callback' => 'null'
        ]);


        if($request->service_type == 'l2tp')
        {
            if(!$request->has('ipsec_psk')) {
                return response()->json([
                    'status' => 'error',
                    'data' => [
                        'reason' => 'some of field is error',
                        'errors' => [
                            'IPSec PSK is required.'
                        ]
                    ]
                ],500);
            }

            $allowedSoftware = [
                'l2tp', 'ovpn'
            ];

            if(!in_array($request->service_type, $allowedSoftware)) {
                
                return response()->json([
                    'status' => 'error',
                    'data' => [
                        'reason' => 'Invalid VPN Software',
                    ]
                ],500);

            }

            VPNSoftware::create([
                'server_id' => $server->id,
                'type' => $request->service_type,
                'l2tp_password' => $request->ipsec_psk
            ]);
        
        }

        return response()->json([
            'status' => 'ok',
            'data' => $request->all(),
            'next' => route('server.list'),
        ],200);
    }

    public function doMonitor() {
        $server = Server::inRandomOrder()->first();
        if(!$server) {
            return abort(404);
        }

        if(isset($_GET['server']))
        {
            $server = Server::where('ip', $_GET['server'])->first();
            if(!$server)
            {
                return abort(404);
            }

            return view('global.server-monitor-init')->with('ip', $server->ip);
        }
        
        return view('global.server-monitor-init')->with('ip', $server->ip);
        
    }

    public function monitor($ip)
    {
        try {
            $ip = decrypt($ip);
        } catch(\Exception $e) {
            return abort(500);
        }

        $server = Server::where('ip', $ip)->first();
        if(!$server) {
            return abort(404);
        }
        
        
        try {
            $ssh = new SSH2($server->ip);
            if (!$ssh->login($server->user, decrypt($server->pass))) {
                return view('global.server-not-connect')->with('ip', $server->ip);
            }
        } catch(\Exception $e) {
            return view('global.server-monitoring-error')->with('ip', $server->ip);
        }

        $client = new Client();

        // check service
        $dropbear = $ssh->exec('cd helpers/monitor/services && bash l2tp');
        $openssh  = $ssh->exec('cd helpers/monitor/services && bash openssh');
        $openvpn  = $ssh->exec('cd helpers/monitor/services && bash openvpn');
        $badvpn   = $ssh->exec('cd helpers/monitor/services && bash badvpn');
        $squid    = $ssh->exec('cd helpers/monitor/services && bash squid');

        

        $http = 1;
        


        // fetch json data from phpsysinfo
        try {
            $res = $client->request('GET', 'http://' . $server->ip . ':4210/xml.php?plugin=complete&json');
        } catch(\Exception $e) {
            return view('global.server-monitoring-error');
        }
        
        $data = json_decode($res->getBody()->getContents());


        //data vital
        $vital = (array)$data->Vitals;
        $v = $vital['@attributes'];
        $hostname = $v->Hostname;
        $ip = $v->IPAddr;
        $kernel = $v->Kernel;
        $distro = $v->Distro;
        $uptime = $v->Uptime;
        $users  = $v->Users;
        @$encoding = @$v->CodePage;
        $proccess = $v->Processes . ' (Running : ' . $v->ProcessesRunning . ' Sleep: ' . $v->ProcessesSleeping . ')';

        // hardware
        $hw  = (array)$data->Hardware->CPU->CpuCore;
        $cpu = count($hw);

        // ram
        $hw  = (array)$data->Memory;
        $ram = $this->bytes1($hw['@attributes']->Total);
        $rambytes = $this->bytes2($hw['@attributes']->Total);
        $ram_total = $this->bytes($hw['@attributes']->Total);
        $ram_used  = $this->bytes($hw['@attributes']->Used);
        $ram_percent = $hw['@attributes']->Percent;

        // storage
        $hw = (array)$data->FileSystem->Mount;
        foreach($hw as $me)
        {
            $r = (array)$me;
            if($r['@attributes']->MountPoint == '/')
            {
                $disk = round($this->bytes1($r['@attributes']->Total));
                $diskbytes = $this->bytes2($r['@attributes']->Total);
                break;
            }
        }
        $disks = $hw;

        // network
        $hw = (array)$data->Network->NetDevice;
        $network = count($hw);
        $networks = $hw;

        if(Auth::user()->role == 'admin')
        {
            return view('admin.server-monitor')
            -> with('hostname', $hostname)
            -> with('ip', $ip)
            -> with('kernel', $kernel)
            -> with('distro', $distro)
            -> with('uptime', $uptime)
            -> with('users', $users)
            -> with('encoding', @$encoding)
            -> with('proccess', $proccess)
            -> with('servers', Server::get())
            -> with('dropbear', $dropbear)
            -> with('openssh', $openssh)
            -> with('openvpn', $openvpn)
            -> with('squid', $squid)
            -> with('badvpn', $badvpn)
            -> with('http', $http)
            -> with('cpu', $cpu)
            -> with('disk', $disk)
            -> with('ram', $ram)
            -> with('network', $network)
            -> with('ram_used', $ram_used)
            -> with('ram_total', $ram_total)
            -> with('ram_percent', $ram_percent)
            -> with('disks', $disks)
            -> with('networks', $networks)
            -> with('rambytes', $rambytes)
            -> with('diskbytes', $diskbytes);
        }
        else
        {
            return view('reseller.server-monitor')
            -> with('hostname', $hostname)
            -> with('ip', $ip)
            -> with('kernel', $kernel)
            -> with('distro', $distro)
            -> with('uptime', $uptime)
            -> with('users', $users)
            -> with('encoding', @$encoding)
            -> with('proccess', $proccess)
            -> with('servers', Server::get())
            -> with('dropbear', $dropbear)
            -> with('openssh', $openssh)
            -> with('openvpn', $openvpn)
            -> with('squid', $squid)
            -> with('badvpn', $badvpn)
            -> with('http', $http)
            -> with('cpu', $cpu)
            -> with('disk', $disk)
            -> with('ram', $ram)
            -> with('network', $network)
            -> with('ram_used', $ram_used)
            -> with('ram_total', $ram_total)
            -> with('ram_percent', $ram_percent)
            -> with('disks', $disks)
            -> with('networks', $networks)
            -> with('rambytes', $rambytes)
            -> with('diskbytes', $diskbytes);
        }
        
    }

    public static function bytes($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . 'GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . 'MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . 'KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . 'b';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . 'B';
        }
        else
        {
            $bytes = '0b';
        }

        return $bytes;
    }

    protected function bytes1($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2);
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2);
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2);
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes;
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes;
        }
        else
        {
            $bytes = 0;
        }

        return $bytes;
    }

    public static function bytes2($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = 'GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = 'MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = 'KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = 'b';
        }
        elseif ($bytes == 1)
        {
            $bytes = 'B';
        }
        else
        {
            $bytes = '0b';
        }

        return $bytes;
    }

    public static function percent($total,$kurangi)
    {
        $sepersen = $total / 100;
        $persenya = round($kurangi / $sepersen);
        $hasil = 100 - $persenya;
        return $hasil;
    }

    public function list_server()
    {
        $server = Server::get();

        return view('admin.server-list')->with('servers', $server);
    }

    public function delete($id)
    {
        $server = Server::where('id', $id)->first();

        if(!$server)
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        Server::where('id', $id)->delete();

        Cert::where('server_id', $id)->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function setting($id)
    {
        $server = Server::where('id', $id)->first();

        if(!$server)
        {
            return "
                <div class='alert alert-danger'>
                    Whoops! Something went wrong!
                </div>
            ";
        }

        return '
            <form method="post" action="/server/add" id="addserver">

                <input type="hidden" name="_token" id="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_id" value="' . $id . '">

                <div class="row clearfix">

                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="server_name" type="text" class="form-control" value="' . $server->name . '" required>
                                <label class="form-label">Server Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="ip_address" type="text" class="form-control" value="' . $server->ip . '" required>
                                <label class="form-label">IP Address</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="user" type="text" class="form-control" value="' . $server->user . '" required>
                                <label class="form-label">User</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="password" type="password" class="form-control" required>
                                <label class="form-label">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="country" type="text" class="form-control" value="' . $server->country . '">
                                <label class="form-label">Country</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <select class="form-control show-tick" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="vpn">VPN</option>
                            <option value="ssh">SSH</option>
                            <option value="both">SSH & VPN</option>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <br />
                        <br />
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="limit_day" type="text" class="form-control" value="' . $server->limit_day . '" required>
                                <label class="form-label">Limit/day (Daily limit)</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="points" type="text" class="form-control" value="' . $server->points . '" required>
                                <label class="form-label">Points/create (Points per create 1 account), EX: 1</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="price" type="text" class="form-control" value="' . $server->price . '" required>
                                <label class="form-label">Price</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="price_point" type="text" class="form-control" value="' . $server->price_point . '" required>
                                <label class="form-label">Price by Point (price if user buy with his point)</label>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="col-sm-12">
                        <button onclick="editServerOnModal()" id="btn-add-server" class="btn bg-teal waves-effect">SAVE</button>
                    </div>

                     </div>
                    </form>
                </div>
            </div>
        ';
    }

    public function edit(Request $request)
    {
        $server = Server::where('id', $request->_id)->first();
        if(!$server)
        {
            return response()->json([
                'success' => false
            ],500);
        }

        $validator = Validator::make($request->all(), [
            'server_name' => 'required',
            'ip_address' => 'required',
            'user' => 'required',
            'password' => 'required',
            'country' => 'required',
            'type' => 'required',
            'limit_day' => 'required',
            'points' => 'required',
            'price' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'data' => [
                    'reason' => 'some of field is error',
                    'errors' => $validator
                ]
            ],500);
        }

        // test server
        try {
            $ssh = new SSH2($server->ip);
            if (!$ssh->login($server->user, decrypt($server->pass))) {
                return response()->json([
                'status' => 'error',
                'data' => [
                    'reason' => 'can\'t connect to remote server',
                ]
            ],500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => [
                    'reason' => 'can\'t connect to remote server',
                ]
            ],500);
        }

        Server::where('id', $request->_id)->update(
        [
            'name' => $request->server_name,
            'ip' => $request->ip_address,
            'user' => $request->user,
            'pass' => encrypt($request->password),
            'country' => $request->country,
            'type' => $request->type,
            'limit' => 0,
            'limit_day' => $request->limit_day,
            'user_created' => 0,
            'total_user' => 0,
            'points' => $request->points,
            'price' => $request->price,
            'price_point' => $request->price_point
        ]
        );

        $server = Server::where('ip', $request->ip_address)->first();

        return response()->json([
            'success' => true,
        ],200);
    }
}
