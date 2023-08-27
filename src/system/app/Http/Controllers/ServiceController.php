<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use phpseclib\Net\SSH2;

class ServiceController extends Controller
{
    public function repairDropbear(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'No server found with IP ' . $request->ip
    			]
    		],406);
    	}

    	$ssh = new SSH2($server->ip);
    	if(!$ssh->login($server->user,decrypt($server->pass)))
    	{
    		return response()->json([
    			'status' => 'Connection Issue',
    			'data' => [
    				'ip' => $server->ip,
    				'reason' => 'System could not open connection to remote server'
    			]
    		],401);
    	}

        $cmd = $ssh->exec('sudo service xl2tpd restart');
    	$cmd = $ssh->exec('sudo service xl2tpd start');
    	$dropbear = $ssh->exec('cd helpers/monitor/services && bash l2tp');

    	if($dropbear == "3")
        {
            // dropbear not installed
            return response()->json([
            	'status' => 'Error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'System unable to repair L2TP'
            	]
            ]);
        }
        elseif($dropbear == "2")
        {
            // dropbear not running
            return response()->json([
            	'status' => 'Error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'System unable to repair L2TP'
            	]
            ]);
        }
        elseif($dropbear == "1")
        {
            // dropbear running
            return response()->json([
            	'status' => 'Service running',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'Service successfully repaired'
            	]
            ],200);
        }
    }

    public function testDropbear(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'Server not found.'
    			]
    		]);
    	}
    	try {
    		$ssh = new SSH2($server->ip);
	    	$ssh->login($server->user,decrypt($server->pass));
    	} catch (\Exception $e) {
    		return response()->json([
    			'status' => 'Refused',
    			'data' => [
    				'ip' => $server->ip,
    				'reason' => 'Server refused the connection.'
    			]
    		],406);
    	}

    	return response()->json([
    		'status' => 'Ok',
    		'data' => [
    			'host' => $ssh->host,
    			'port' => $ssh->port,
    			'client_identifier' => $ssh->identifier,
    			'server_identifier' => $ssh->server_identifier,
    			'kex_algorithm' => $ssh->kex_algorithms,
    			'server_algorithm' => $ssh->server_host_key_algorithms,
    			'client_encryption_algorithm' => $ssh->encryption_algorithms_client_to_server,
    			'server_encryption_algorithm' => $ssh->encryption_algorithms_server_to_client,
    			'client_mac_algorithm' => $ssh->mac_algorithms_client_to_server,
    			'server_mac_algorithm' => $ssh->mac_algorithms_server_to_client,
    			'client_compression_algorithm' => $ssh->compression_algorithms_client_to_server,
    			'server_compression_algorithm' => $ssh->compression_algorithms_server_to_client,
    		]
    	],200); 
    }

    public function repairSquid(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'No server found with IP ' . $request->ip
    			]
    		],406);
    	}

    	$ssh = new SSH2($server->ip);
    	if(!$ssh->login($server->user,decrypt($server->pass)))
    	{
    		return response()->json([
    			'status' => 'Connection Issue',
    			'data' => [
    				'ip' => $server->ip,
    				'reason' => 'System could not open connection to remote server'
    			]
    		],401);
    	}

    	$cmd = $ssh->exec('sudo service squid restart');
    	$cmd = $ssh->exec('sudo service squid3 restart');
    	$squid = $ssh->exec('cd helpers/monitor/services && bash squid');

    	if($squid == "3")
        {
            // dropbear not installed
            return response()->json([
            	'status' => 'Error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'System unable to repair Squid'
            	]
            ]);
        }
        elseif($squid == "2")
        {
            // dropbear not running
            return response()->json([
            	'status' => 'Error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'System unable to repair Squid'
            	]
            ]);
        }
        elseif($squid == "1")
        {
            // dropbear running
            return response()->json([
            	'status' => 'Service running',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'Service successfully repaired'
            	]
            ],200);
        }
    }

    public function testSquid(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'Server not found.'
    			]
    		]);
    	}

    	$ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return view('admin.server-not-connect');
        }

        $squid = $ssh->exec('cd helpers/monitor/services && bash squid');

        if($squid == "3")
        {
            return response()->json([
            	'status' => 'error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'Squid Not Installed.'
            	]
           	],400);
        }
        elseif($squid == "2")
        {
            return response()->json([
            	'status' => 'error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'Squid Not Running.'
            	]
           	],406);
        }
        elseif($squid == "1")
        {
            return response()->json([
            	'status' => 'ok',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'Squid Test : Running..'
            	]
           	],200);
        }
    }

    public function repairOpenVPN(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'No server found with IP ' . $request->ip
    			]
    		],406);
    	}

    	$ssh = new SSH2($server->ip);
    	if(!$ssh->login($server->user,decrypt($server->pass)))
    	{
    		return response()->json([
    			'status' => 'Connection Issue',
    			'data' => [
    				'ip' => $server->ip,
    				'reason' => 'System could not open connection to remote server'
    			]
    		],401);
    	}

    	$cmd = $ssh->exec('sudo service openvpn restart');
    	$openvpn = $ssh->exec('cd helpers/monitor/services && openvpn');

    	if($openvpn == "3")
        {
            // dropbear not installed
            return response()->json([
            	'status' => 'Error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'System unable to repair OpenVPN'
            	]
            ]);
        }
        elseif($openvpn == "2")
        {
            // dropbear not running
            return response()->json([
            	'status' => 'Error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'System unable to repair OpenVPN'
            	]
            ]);
        }
        elseif($openvpn == "1")
        {
            // dropbear running
            return response()->json([
            	'status' => 'Service running',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'Service successfully repaired'
            	]
            ],200);
        }
    }

    public function testOpenVPN(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'Server not found.'
    			]
    		]);
    	}

    	$ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return view('admin.server-not-connect');
        }

        $squid = $ssh->exec('cd helpers/monitor/services && bash openvpn');

        if($squid == "3")
        {
            return response()->json([
            	'status' => 'error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'OpenVPN Not Installed.'
            	]
           	],400);
        }
        elseif($squid == "2")
        {
            return response()->json([
            	'status' => 'error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'OpenVPN Not Running.'
            	]
           	],406);
        }
        elseif($squid == "1")
        {
            return response()->json([
            	'status' => 'ok',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'OpenVPN Test : Running..'
            	]
           	],200);
        }
    }

    public function testBadVPN(Request $request)
    {
    	$server = Server::where('ip', $request->ip)->first();
    	if(!$server)
    	{
    		return response()->json([
    			'status' => 'No Server',
    			'data' => [
    				'ip' => $request->ip,
    				'reason' => 'Server not found.'
    			]
    		]);
    	}

    	$ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return view('admin.server-not-connect');
        }

        $squid = $ssh->exec('cd helpers/monitor/services && bash badvpn');

        if($squid == "3")
        {
            return response()->json([
            	'status' => 'error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'BadVPN Not Installed.'
            	]
           	],400);
        }
        elseif($squid == "2")
        {
            return response()->json([
            	'status' => 'error',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'BadVPN Not Running.'
            	]
           	],406);
        }
        elseif($squid == "1")
        {
            return response()->json([
            	'status' => 'ok',
            	'data' => [
            		'ip' => $server->ip,
            		'reason' => 'BadVPN Test : Running..'
            	]
           	],200);
        }
    }
}

