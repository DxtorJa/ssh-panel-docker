<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Dns;
use App\Zone;
use App\Admin;
use Validator;

class DNSController extends Controller
{
  public $user;

  private $cf_email;

	private $cf_key;

	private $http;

	private $endpoint;


  public function __construct() {
    $this->user = Auth::guard('api')->user();
    $cf = Admin::first();
		$this->cf_email = $cf->cf_email_key;
		$this->cf_key = $cf->cf_api_key;
		$this->http = new Client(['base_uri' => 'https://api.cloudflare.com']);
		$this->endpoint = '/client/v4';
  }

  public function index() {
    return response()->json([
      'error' => false,
      'code' => 200,
      'message' => 'OK',
      'details' => Dns::where('reseller_email', $this->user->email)->get()->toArray(),
      'trace' => '#' . str_random(5)
    ], 200, [], JSON_PRETTY_PRINT);
  }

  public function destroy($id) {
    $dns = Dns::where('id', $id)->where('reseller_email', $this->user->email)->first();
    if(!$dns) {
      return response()->json([
        'error' => true,
        'code' => 404,
        'message' => 'Not Found',
        'details' => [
            'severity' => 'Warning',
            'reason' => 'The specified resource was not found!'
        ],
        'trace' => '#' . str_random(5)
      ],404,[], JSON_PRETTY_PRINT);
    }

    $res = $this->http->request('DELETE', $this->endpoint . '/zones/' . $dns->zone_id . '/dns_records/' . $dns->record_id,[
      'headers' => [
        'X-Auth-Email' => $this->cf_email,
        'X-Auth-Key' => $this->cf_key,
        'Content-Type' => 'application/json'
      ]
    ]);

    $result = json_decode($res->getBody()->getContents());
    if($result->success)
    {
        $dns->delete();
        return response()->json([
            'error' => false,
            'code' => 200,
            'message' => 'OK',
            'details' => [
                'record_id' => $result->result->id,
                'reason' => 'The provided resource was processed successfully'
            ],
            'trace' => '#' . str_random(5)
        ], 200, [], JSON_PRETTY_PRINT);
    }

    return response()->json([
        'error' => true,
        'code' => 500,
        'message' => 'Internal Server Error',
        'details' => [
            'severity' => 'Info!',
            'reason' => 'Internal Server Error'
        ],
        'trace' => '#' . str_random(5)
    ],500,[], JSON_PRETTY_PRINT);

  }

  public function create(Request $request) {

      $rules = [
          'zone_id' => 'required|integer',
          'subdomain' => 'required',
          'remote_ip' => 'required|ip'
      ];

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
          'error' => true,
          'code' => 422,
          'message' => 'Unprocessable Entity',
          'details' => [
            'severity' => 'Warning!',
            'reason' => 'The JSON Payload doesn\'t meet the validation rules.',
          ],
          'trace' => '#' . str_random(5)
        ],422,[], JSON_PRETTY_PRINT);
      }

      // First check the zone id exists
      $zone = Zone::find($request->zone_id);
      if(!$zone) {
        return response()->json([
            'error' => true,
            'code' => 404,
            'message' => 'Not Found',
            'details' => [
                'severity' => 'Warning!',
                'reason' => 'The provided resource was not found.'
            ],
            'trace' => '#' . str_random(5)
        ]);
      }

      // Zone exists! Now check the subdomain
      $dns = Dns::where('subdomain', $request->subdomain . '.' . $zone->zone_name)->first();
      if($dns) {
        return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
                'severity' => 'Info!',
                'reason' => 'The provided resource was exists.'
            ],
            'trace' => '#' . str_random(5)
        ]);
      }

      // Dns are free to create!
      $res = $this->http->request('POST', $this->endpoint . '/zones/' . $zone->zone_id . '/dns_records', [
    		'headers' => [
    			'X-Auth-Key' => $this->cf_key,
    			'X-Auth-Email' => $this->cf_email,
    			'Content-Type' => 'application/json'
    		],
    		'json' => [
    			'type' => 'A',
    			'name' => $request->subdomain,
    			'content' => $request->remote_ip,
    			'ttl' => 120,
    			'proxied' => false,
    		]
    	]);

      $result = json_decode($res->getBody()->getContents());
      if($result->success) {
        $dns = Dns::create([
            'reseller_email' => $this->user->email,
            'subdomain' => $request->subdomain . '.' . $zone->zone_name,
            'pointed_to' => $request->remote_ip,
            'record_id' => $result->result->id,
            'zone_id' => $zone->zone_id
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'details' => [
                'query' => $dns,
                'cloudflare' => [
                  $result
                ],
            ],
            'trace' => '#' . str_random(5)
        ], 200, [], JSON_PRETTY_PRINT);
      }
  }

}
