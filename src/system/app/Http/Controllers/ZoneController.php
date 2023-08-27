<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use \GuzzleHttp\Client;
use App\Zone;
use App\Dns;
use Auth;

class ZoneController extends Controller
{
    
	private $cf_email;

	private $cf_key;

	private $http;

	private $endpoint;

	public function __construct()
	{
		$cf = Admin::first();
		$this->cf_email = $cf->cf_email_key;
		$this->cf_key = $cf->cf_api_key;
		$this->http = new Client(['base_uri' => 'https://api.cloudflare.com']);
		$this->endpoint = '/client/v4';
	}

    public function index()
    {
    	try {
           $res = $this->http->request('GET', $this->endpoint . '/zones',[
                'headers' => [
                    'X-Auth-Key' => $this->cf_key,
                    'X-Auth-Email' => $this->cf_email
                ]
            ]); 
        } catch (\Exception $e) {
            return redirect('/admin')->withErrors([
                'cloudflare_dns' => 'Whoops! You need to enter correct credentials for Cloudflare API'
            ]);
        }

    	$results = json_decode($res->getBody()->getContents(),true);


    	return view('admin.dns-list')->with('results', $results['result']);
    }

    public function add(Request $request)
    {
    	$zone = Zone::where('zone_id', $request->id)->first();
    	if(!$zone)
    	{
    		$res = $this->http->request('GET', $this->endpoint . '/zones/' . $request->id, [
    			'headers' => [
    				'X-Auth-Email' => $this->cf_email,
    				'X-Auth-Key' => $this->cf_key
    			]
    		]);

    		$data = json_decode($res->getBody()->getContents(),true);
    		if($data['success'])
    		{
    			Zone::create([
    				'zone_id' => $request->id,
    				'zone_name' => $data['result']['name'],
    				'zone_count' => 0
    			]);

    			return response()->json([
    				'success' => true,
    			],200);
    		}

    		return response()->json([
    			'success' => false,
    		],500);
    	}

    	return response()->json([
    		'success' => false,
    	],500);
    }

    public function create()
    {
    	$zone = Zone::get();
    	return view('global.create-dns')->with('zones', $zone);
    }

    public function doCreate(Request $request)
    {
    	$zone = Zone::where('zone_name', $request->zone)->first();
    	if(!$zone)
    	{
    		return response()->json([
    			'success' => false,
    		],500);
    	}

    	$res = $this->http->request('POST', $this->endpoint . '/zones/' . $zone->zone_id . '/dns_records', [
    		'headers' => [
    			'X-Auth-Key' => $this->cf_key,
    			'X-Auth-Email' => $this->cf_email,
    			'Content-Type' => 'application/json'
    		],
    		'json' => [
    			'type' => 'A',
    			'name' => $request->hostname,
    			'content' => $request->ip,
    			'ttl' => 120,
    			'proxied' => false,
    		]
    	]);

    	$data = json_decode($res->getBody()->getContents(), true);
    	if($data['success'])
    	{
    		Dns::create([
    			'reseller_email' => Auth::user()->email,
    			'subdomain' => $request->hostname . '.' . $request->zone,
    			'pointed_to' => $request->ip,
    			'record_id' => $data['result']['id'],
    			'zone_id' => $zone->zone_id,
    		]);

    		return response()->json([
    			'success' => true,
    		]);
    	}

    	return response()->json([
			'success' => true,
		],500);
    }

    public function list_zone()
    {
    	$dns = Dns::where('reseller_email', Auth::user()->email)->get();

    	return view('global.dns-list')->with('dns', $dns);
    }

    public function delete(Request $request)
    {
    	$dns = Dns::where('id', $request->id)->where('reseller_email', Auth::user()->email)->first();
    	if(!$dns)
    	{
    		return response()->json([
    			'success' => false,
    		]);
    	}

    	

    	$res = $this->http->request('DELETE', $this->endpoint . '/zones/' . $dns->zone_id . '/dns_records/' . $dns->record_id,[
    		'headers' => [
    			'X-Auth-Email' => $this->cf_email,
    			'X-Auth-Key' => $this->cf_key,
    			'Content-Type' => 'application/json'
    		]
    	]);

    	$data = json_decode($res->getBody()->getContents(),true);
    	if($data['success'])
    	{
    		Dns::where('id', $request->id)->delete();

    		return response()->json([
    			'success' => true,
    		]);
    	}

    	return response()->json([
			'success' => false,
		],500);
    }

    public function addmanual(Request $request)
    {
    	$res = $this->http->request('POST', $this->endpoint . '/zones/', [
    		'headers' => [
    			'X-Auth-Key' => $this->cf_key,
    			'X-Auth-Email' => $this->cf_email,
    			'Content-Type' => 'application/json'
    		],
    		'json' => [
    			'name' => $request->domain
    		]
    	]);

    	$data = json_decode($res->getBody()->getContents(),true);
    	if($data['success'])
    	{
    		Zone::create([
    			'zone_id' => $data['result']['id'],
    			'zone_name' => $data['result']['name'],
    			'zone_count' => 0
    		]);

    		return response()->json([
    			'success' => true,
    		]);
    	}

    	return response()->json([
			'success' => false,
		],500);
    }

    public function remove(Request $request)
    {
    	$res = $this->http->request('DELETE', $this->endpoint . '/zones/' . $request->id, [
    		'headers' => [
    			'X-Auth-Email' => $this->cf_email,
    			'X-Auth-Key' => $this->cf_key,
    			'Content-Type' => 'application/json'
    		]
    	]);

    	$data = json_decode($res->getBody()->getContents(),true);
    	if($data['success'])
    	{
    		return response()->json([
    			'succes' => true,
    		]);
    	}

    	return response()->json([
			'succes' => false,
		],500);
    }
}
