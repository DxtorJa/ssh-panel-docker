<?php

namespace App\Http\Controllers;

use App\Ssh;
use App\Vpn;
use App\Server;
use Illuminate\Http\Request;
use phpseclib\Net\SSH2;

class CronsController extends Controller
{
    protected $allowedAction = [
        'remove_trial_account',
        'reset_daily_limit'
    ];

    public function index(Request $request) {
        if($request->has('action') && $request->has('key')) {
            return in_array($request->action, $this->allowedAction)
                ? $this->doCron($request->action, $request)
                : abort(404);
        }

        abort(404);
    }

    protected function doCron($action, Request $request) {
        $key = env('CRONS_KEY');

        if($key != $request->key) {
            return abort(404);
        }

        $server = Server::get();
        $ssh_account = Ssh::where('status', 'trial')->get();
        $vpn_account = Vpn::where('status', 'trial')->get();

        if($action == 'remove_trial_account') {
            foreach($ssh_account as $sa) {
                $server = Server::where('ip', $sa->at_server)->first();
                if(!$server) {
                    continue;
                }

                try {
                    $ssh = new SSH2($server->ip);
                    if(!$ssh->login($server->user, decrypt($server->pass))) {
                        continue;
                    }
                    $ssh->exec('userdel ' . $sa->username);
                } catch (\Exception $e) {
                    continue;
                }

                echo $sa->username . ' deleted! <br />';
                $sa->delete();

            }

            foreach($vpn_account as $sa) {
                $server = Server::where('ip', $sa->at_server)->first();
                if(!$server) {
                    continue;
                }

                try {
                    $ssh = new SSH2($server->ip);
                    if(!$ssh->login($server->user, decrypt($server->pass))) {
                        continue;
                    }
                    $ssh->exec('userdel ' . $sa->username);
                } catch (\Exception $e) {
                    continue;
                }

                echo $sa->username . ' deleted! <br />';
                $sa->delete();

            }
        }
        
        if($action == 'reset_daily_limit') {
            foreach($server as $ser) {
                $ser->update([
                    'limit' => false,
                    'user_created' => 0
                ]);
                echo "Server " . $ser->ip . ' resetted! <br />';
            }
        }
    }
}
