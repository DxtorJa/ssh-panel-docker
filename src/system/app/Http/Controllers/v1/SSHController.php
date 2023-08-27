<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpseclib\Net\SSH2;
use App\Ssh;
use App\Server;
use App\Trial;
use App\User;
use Validator;
use Auth;

class SSHController extends Controller
{

    public $user;

    public function __construct() {
      $this->user = Auth::guard('api')->user();
    }

    public function index() {
      $ssh = Ssh::where('reseller_email', $this->user->email)->get();
      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => $ssh->toArray(),
          'trace' => '#' . str_random(5)
      ],200, [], JSON_PRETTY_PRINT);
    }

    public function read($id) {
      $ssh = Ssh::find($id);
      if(!$ssh) {
        return response()->json([
          'error' => true,
          'code' => 404,
          'message' => 'Not Found',
          'details' => [
              'severity' => 'Warning',
              'reason' => 'The specified resource was not found!'
          ],
          'trace' => '#' . str_random(5)
        ], 404, [], JSON_PRETTY_PRINT);
      }

      return response()->json([
        'error' => false,
        'code' => 200,
        'message' => 'OK',
        'details' => $ssh->toArray(),
        'trace' => '#' . str_random(5)

      ], 200, [], JSON_PRETTY_PRINT);
    }

    public function create(Request $request) {

        $rules = [
          'server_id' => 'required|integer',
          'username' => 'required',
          'password' => 'required',
          'duration' => 'required',
          'payment_method' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
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

        // cek if server available
        $server = Server::where('id', $request->server_id)
                        -> where('type', 'ssh')
                        -> orWhere('type', 'both')
                        -> first();
        if(!$server) {
          return response()->json([
            'error' => true,
            'code' => 404,
            'message' => 'Not Found',
            'details' => [
                'severity' => 'Warning',
                'reason' => 'The specified resource was not found!'
            ],
            'trace' => '#' . str_random(5)
          ], 404, [], JSON_PRETTY_PRINT);
        }

        // check if duration is not trial
        if($request->duration == 'trial')
        {
          // check if trial quote still exists.
          $trial = Trial::where('reseller_email', $this->user->email)->get();

          if($trial->count() >= 5) {

            return response()->json([
              'error' => true,
              'code' => 422,
              'message' => 'Unprocessable Entity',
              'details' => [
                'severity' => 'Fatal!',
                'reason' => 'Trial Quote reach maximum amount/day.',
              ],
              'trace' => '#' . str_random(5)
            ],422,[], JSON_PRETTY_PRINT);

          }

          // trial exists

          return $this->createTrialAccount($request);

        }

        // server exists and we need to confirm balance because duration is not trial
        if($request->payment_method == 'balance')
        {
            // cek if balance meet the account price.
            if(is_int($request->duration)) {
              $price = $server->price * $request->duration;
              if($this->user->balance >= $price)
              {
                  return $this->createSSH($request, $price);
              }

              return response()->json([
                'error' => true,
                'code' => 422,
                'message' => 'Unprocessable Entity',
                'details' => [
                  'severity' => 'Fatal!',
                  'reason' => 'Low balance.',
                ],
                'trace' => '#' . str_random(5)
              ],422,[], JSON_PRETTY_PRINT);
            }

            return response()->json([
              'error' => true,
              'code' => 422,
              'message' => 'Unprocessable Entity',
              'details' => [
                'severity' => 'Fatal!',
                'reason' => 'The Invalid value given on JSON Payload.',
              ],
              'trace' => '#' . str_random(5)
            ],422,[], JSON_PRETTY_PRINT);
        }
        elseif($request->payment_method == 'point')
        {
            if(is_int($request->duration)) {
              $price = $server->price_point * $request->duration;
              if($this->user->point >= $price){
                return $this->createSSHWithPoint($request, $price);
              }

              return response()->json([
                'error' => true,
                'code' => 422,
                'message' => 'Unprocessable Entity',
                'details' => [
                  'severity' => 'Fatal!',
                  'reason' => 'Low point.',
                ],
                'trace' => '#' . str_random(5)
              ],422,[], JSON_PRETTY_PRINT);

            }

            return response()->json([
              'error' => true,
              'code' => 422,
              'message' => 'Unprocessable Entity',
              'details' => [
                'severity' => 'Fatal!',
                'reason' => 'The Invalid value given on JSON Payload.',
              ],
              'trace' => '#' . str_random(5)
            ],422,[], JSON_PRETTY_PRINT);
        }
        else
        {
          return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
              'severity' => 'Fatal!',
              'reason' => 'The Invalid value given on JSON Payload.',
            ],
            'trace' => '#' . str_random(5)
          ],422,[], JSON_PRETTY_PRINT);
        }
    }

    public function createTrialAccount($request) {

        $server = Server::where('id', $request->server_id)->first();

        if(!$server)
        {
          return response()->json([
            'error' => true,
            'code' => 404,
            'message' => 'Not Found',
            'details' => [
                'severity' => 'Warning',
                'reason' => 'The specified resource was not found!'
            ],
            'trace' => '#' . str_random(5)
          ], 404, [], JSON_PRETTY_PRINT);
        }
        // check connection

        $ssh = new SSH2($server->ip);
        try {
          $ssh->login($server->user, decrypt($server->pass));
        } catch (\Exception $e) {
          return response()->json([
            'error' => true,
            'code' => 500,
            'message' => 'Internal Server Error',
            'details' => [
              'severity' => 'Fatal!',
              'reason' => 'Error establishhing connection to remote server.',
            ],
            'trace' => '#' . str_random(5)
          ],500,[], JSON_PRETTY_PRINT);
        }

        // check if account exists
        $check = Ssh::where('username', $request->username)
                    -> where('at_server', $server->ip)
                    -> first();
        if($check)
        {
          return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
              'severity' => 'Info!',
              'reason' => 'The Provided resource was exists.',
            ],
            'trace' => '#' . str_random(5)
          ],422,[], JSON_PRETTY_PRINT);
        }

        $ssh->exec('useradd ' . $request->username . ' -m -s /bin/false');
    		$ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');

        Trial::create([
          'reseller_email' => $this->user->email,
          'create_date' => date('d-m-Y'),
        ]);

        $ssh = Ssh::create([
          'reseller_email' => $this->user->email,
          'username' => $request->username,
          'at_server' => $server->ip,
          'status' => 'trial',
          'expired_on' => date('d-m-Y'),
        ]);

        return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => $ssh->toArray(),
          'trace' => '#' . str_random(5)

        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function createSSH($request, $price) {

        $server = Server::where('id', $request->server_id)->first();

        if(!$server)
        {
          return response()->json([
            'error' => true,
            'code' => 404,
            'message' => 'Not Found',
            'details' => [
                'severity' => 'Warning',
                'reason' => 'The specified resource was not found!'
            ],
            'trace' => '#' . str_random(5)
          ], 404, [], JSON_PRETTY_PRINT);
        }
        // check connection

        $ssh = new SSH2($server->ip);
        try {
          $ssh->login($server->user, decrypt($server->pass));
        } catch (\Exception $e) {
          return response()->json([
            'error' => true,
            'code' => 500,
            'message' => 'Internal Server Error',
            'details' => [
              'severity' => 'Fatal!',
              'reason' => 'Error establishhing connection to remote server.',
            ],
            'trace' => '#' . str_random(5)
          ],500,[], JSON_PRETTY_PRINT);
        }

        // check if account exists
        $check = Ssh::where('username', $request->username)
                    -> where('at_server', $server->ip)
                    -> first();
        if($check)
        {
          return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
              'severity' => 'Info!',
              'reason' => 'The Provided resource was exists.',
            ],
            'trace' => '#' . str_random(5)
          ],422,[], JSON_PRETTY_PRINT);
        }

        $ssh->exec('useradd ' . $request->username . ' -m -s /bin/false');
    		$ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');

        User::where('email', $this->user->email)->decrement('balance', $price);

        $ssh = Ssh::create([
          'reseller_email' => $this->user->email,
          'username' => $request->username,
          'at_server' => $server->ip,
          'status' => 'active',
          'expired_on' => \Carbon\Carbon::now()->addMonths($request->duration),
        ]);

        return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => $ssh->toArray(),
          'trace' => '#' . str_random(5)

        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function createSSHWithPoint($request, $price) {
      $server = Server::where('id', $request->server_id)->first();

      if(!$server)
      {
        return response()->json([
          'error' => true,
          'code' => 404,
          'message' => 'Not Found',
          'details' => [
              'severity' => 'Warning',
              'reason' => 'The specified resource was not found!'
          ],
          'trace' => '#' . str_random(5)
        ], 404, [], JSON_PRETTY_PRINT);
      }
      // check connection

      $ssh = new SSH2($server->ip);
      try {
        $ssh->login($server->user, decrypt($server->pass));
      } catch (\Exception $e) {
        return response()->json([
          'error' => true,
          'code' => 500,
          'message' => 'Internal Server Error',
          'details' => [
            'severity' => 'Fatal!',
            'reason' => 'Error establishhing connection to remote server.',
          ],
          'trace' => '#' . str_random(5)
        ],500,[], JSON_PRETTY_PRINT);
      }

      // check if account exists
      $check = Ssh::where('username', $request->username)
                  -> where('at_server', $server->ip)
                  -> first();
      if($check)
      {
        return response()->json([
          'error' => true,
          'code' => 422,
          'message' => 'Unprocessable Entity',
          'details' => [
            'severity' => 'Info!',
            'reason' => 'The Provided resource was exists.',
          ],
          'trace' => '#' . str_random(5)
        ],422,[], JSON_PRETTY_PRINT);
      }

      $ssh->exec('useradd ' . $request->username . ' -m -s /bin/false');
      $ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');

      User::where('email', $this->user->email)->decrement('point', $price);

      $ssh = Ssh::create([
        'reseller_email' => $this->user->email,
        'username' => $request->username,
        'at_server' => $server->ip,
        'status' => 'active',
        'expired_on' => \Carbon\Carbon::now()->addMonths($request->duration),
      ]);

      return response()->json([
        'error' => false,
        'code' => 200,
        'message' => 'OK',
        'details' => $ssh->toArray(),
        'trace' => '#' . str_random(5)

      ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id) {
      $account = Ssh::find($id);
      if(!$account)
      {
        return response()->json([
          'error' => true,
          'code' => 404,
          'message' => 'Not Found',
          'details' => [
              'severity' => 'Warning',
              'reason' => 'The specified resource was not found!'
          ],
          'trace' => '#' . str_random(5)
        ], 404, [], JSON_PRETTY_PRINT);
      }

      $server = Server::where('ip', $account->at_server)->first();
      if(!$server)
      {
        return response()->json([
          'error' => true,
          'code' => 404,
          'message' => 'Not Found',
          'details' => [
              'severity' => 'Warning',
              'reason' => 'The specified resource was not found!'
          ],
          'trace' => '#' . str_random(5)
        ], 404, [], JSON_PRETTY_PRINT);
      }

      $ssh = new SSH2($server->ip);
      try {
        $ssh->login($server->user,decrypt($server->pass));
      } catch (\Exception $e) {
        return response()->json([
          'error' => true,
          'code' => 500,
          'message' => 'Internal Server Error',
          'details' => [
            'severity' => 'Fatal!',
            'reason' => 'Error establishhing connection to remote server.',
          ],
          'trace' => '#' . str_random(5)
        ],500,[], JSON_PRETTY_PRINT);
      }

      $ssh->exec('userdel ' . $account->username);
      Ssh::where('id', $account->id)->delete();

      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => [
              'severity' => 'Safe!',
              'reason' => 'The Provided resource was successfully processed!'
          ],
          'trace' => '#' . str_random(5)
      ], 200, [], JSON_PRETTY_PRINT);
    }
}
