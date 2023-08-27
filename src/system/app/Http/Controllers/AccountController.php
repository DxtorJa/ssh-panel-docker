<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vpn;
use App\Ssh;
use App\Server;
use App\Trial;
use App\Log;
use Auth;
use Validator;
use phpseclib\Net\SSH2;
use App\Pesan;
use App\Notif;
use App\Notes;
use \Carbon\Carbon;

class AccountController extends Controller
{

	/**
	 * @return account type
	 */

	public $type;

	/**
	 * @return current authenticated user
	 */

	public $user;

	/**
	 * @return server resource.
	 */

	public $server;

	/**
	 * @return ssh / vpn username.
	 */

	public $username;

	/**
	 * @return ssh / vpn password.
	 */

	public $password;

	/**
	 * @return ssh / vpn duration.
	 */

    public $duration;
    
    /**
	 * @return ssh / vpn duration.
	 */

	public $durationDate;

	/**
	 * @return message,
	 */

	public $message;

	/**
	 * @return User trial account.
	 */

	public $trialCount;

	/**
	 * @return trial percent.
	 */

	public $trialPercent;

	/**
	 * @return curent date time.
	 */

	public $now;

	/**
	 * @return price.
	 */

	public $price;

    /**
     * @return ssh resources.
     */

    public $ssh;

    /**
     * @return vpn resources.
     */

    public $vpn;

    /**
     * Note ya anjing
     *
     * @var string
     */
    protected $note;

    public function __construct()
    {
    	$this->middleware(function ($request, $next) {
	        $this->user = Auth::user();

	        return $next($request);
	    });
    	// return dd($this->middleware('auth'));
    	// $this->middleware('auth');
    	// $this->user = User::where('email', Auth::user()->email)->first();
    	$this->message = Pesan::where('id', 1)->first();
    	$this->now = Carbon::now();
    }

    public function indexSSH()
    {
    	$server = Server::where('limit', 0)->where('type','ssh')->orWhere('type', 'both')->get();
    	return view('global.choose-ssh-server')->with('servers', $server);
    }

    public function indexVPN()
    {
    	$server = Server::where('limit', 0)->where('type','vpn')->orWhere('type', 'both')->get();
    	return view('global.choose-vpn-server')->with('servers', $server);
    }

    public function ssh($ip)
    {
    	$server = Server::where('ip', $ip)->first();
    	if(!$server)
    	{
    		return abort(404);
    	}

    	$trialAccount = Trial::where('reseller_email', Auth::user()->email)->where('create_date', date('d-m-Y'))->get();
    	
        if(Auth::user()->role == 'admin') {
            $ssh = Ssh::where('status', '!=', 'trial')->get();
            $vpn = Vpn::where('status', '!=', 'trial')->get();

        }
        else 
        {
            $ssh = Ssh::where('reseller_email', Auth::user()->email)->where('status', '!=', 'trial')->get();
            $vpn = Vpn::where('reseller_email', Auth::user()->email)->where('status', '!=', 'trial')->get();

        }

    	return view('global.create-ssh')->with('server', $server)
    		-> with('user', Auth::user())
    		-> with('trial',$trialAccount)
    		-> with('vpn', $vpn)
    		-> with('ssh', $ssh);
    }

    public function vpn($ip)
    {
        $server = Server::where('ip', $ip)->first();
        if(!$server)
        {
            return abort(404);
        }

        $trialAccount = Trial::where('reseller_email', Auth::user()->email)->where('create_date', date('d-m-Y'))->get();
        if (Auth::user()->role == 'admin') {
            $ssh = Ssh::where('status', '!=', 'trial')->get();
            $vpn = Vpn::where('status', '!=', 'trial')->get();

        } else {
            $ssh = Ssh::where('reseller_email', Auth::user()->email)->where('status', '!=', 'trial')->get();
            $vpn = Vpn::where('reseller_email', Auth::user()->email)->where('status', '!=', 'trial')->get();

        }

        return view('global.create-vpn')->with('server', $server)
            -> with('user', Auth::user())
            -> with('trial',$trialAccount)
            -> with('vpn', $vpn)
            -> with('ssh', $ssh);
    }

    public function createSSH(Request $request)
    {

    	$message = [
    		"captcha.required" => 'The :attribute field is required.',
    		"captcha.captcha" => 'The entering :attribute value does not match server response.'
    	];

    	$validator = Validator::make($request->all(),[
    		'username' => 'required',
    		'password' => 'required',
    		'duration' => 'required'
    	],$message);

        $this->note = $request->note;

    	if($validator->fails())
    	{
    		return response()->json([
    			'response' => 'Validation Error',
    			'data' => [
    				'reason' => 'Some error detected.',
    				'error' => json_decode($validator->errors())
    			]
    		],422);
    	}

    	if($this->isServerExistsByIP($request->_server))
    	{
    		$this->server = Server::where('ip',$request->_server)->first();
    	}
    	else
    	{
    		return $this->flashMessage('error', [
    			'status' => 'Error',
    			'data' => [
    				'reason' => 'Server you are trying to create account does not exists.'
    			]
    		]);
    	}

        if($request->duration == 'trial')
        {
            return $this->doTrialTask($request,'ssh');
        }

    	if($this->checkAdmin())
    	{
    		return $this->doPremiumTask($request,'ssh');
    	}

    	return $this->doPremiumTask($request,'ssh');
    }

    private function doCreateSSH()
    {
        $server = $this->server;

    	$ssh = new SSH2($server->ip);
    	if(!$ssh->login($server->user,decrypt($server->pass)))
    	{
    		return view('global.server-not-connect');
    	}

    	if($this->duration == 'trial')
    	{
    		$ssh->exec('useradd ' . $this->username . ' -m -s /bin/false');
    		$ssh->exec('echo ' . $this->username . ':' . $this->password . ' | chpasswd');

    		// updating database record.

    		// updating trial count.
    		Trial::create([
    			'reseller_email' => $this->user->email,
    			'create_date' => date('d-m-Y'),
    		]);

    		// updating ssh user.
    		Ssh::create([
    			'username' => $this->username,
                'reseller_email' => $this->user->email,
    			'at_server' => $this->server->ip,
    			'status' => 'trial',
    			'expired_on' => date('d-m-Y'),
    		]);

    		// updating logs table.
    		Log::create([
    			'task_name' => 'Trial SSH Account Successfully created!',
    			'message' => $this->user->name . ' Successfully create trial SSH Account on ' . date('d-m-Y'),
    			'triggerer' => $this->user->email,
    		]);

    		$this->trialCount = Trial::where('reseller_email', $this->user->email)->count();
 			$this->trialPercent = $this->trialCount / 5 * 100;

    		return $this->flashMessage('success', [
    			'status' => 'Trial Success',
    			'details' => [
    				'username' => $this->username,
    				'password' => $this->password,
    				'host' => $this->server->ip,
    			],
    			'message' => ($this->user->role == 'admin') ? $this->message->pesan_trial_sukses_admin : $this->message->pesan_trial_sukses,
    			'trial_account' => $this->trialCount,
    			'percent' => $this->trialPercent,
    		]);
    	}

    	$ssh->exec('useradd -e `date -d "' . $this->duration . ' months" +"%Y-%m-%d"` -m -s /bin/false ' . $this->username);
    	$ssh->exec('echo ' . $this->username . ':' . $this->password . ' | chpasswd');

    	// updating database record.
    	$sshAccount = Ssh::create([
			'username' => $this->username,
            'reseller_email' => $this->user->email,
			'at_server' => $this->server->ip,
			'status' => 'active',
			'expired_on' => $this->now->addMonths($this->duration),
		]);

        Notes::create([
            'account_id' => $sshAccount->id,
            'content' => $this->note
        ]);

        // updatin servers record.
        Server::where('ip', $this->server->ip)->increment('user_created');

		// updating logs table.
		Log::create([
			'task_name' => 'SSH Account Successfully created!',
			'message' => $this->user->name . ' Successfully create SSH Account on ' . date('d-m-Y') . ' Active until ' . $this->now->addMonths($this->duration),
			'triggerer' => $this->user->email,
		]);

        

		// decrements balance & incrementing points.
        $this->cutBalance($this->price);
		User::where('id', $this->user->id)->increment('point', $this->server->points * $this->duration);
        $this->ssh = Ssh::where('reseller_email', $this->user->email);
        $this->user = User::where('email', $this->user->email)->first();

    	return $this->flashMessage('success', [
    		'status' => 'Ok',
    		'details' => [
    			'username' => $this->username,
    			'password' => $this->password,
    			'host' => $this->server->ip,
    		],
    		'message' => ($this->user->role == 'admin') ? $this->message->pesan_ssh_sukses : $this->message->pesan_ssh_sukses_admin,
    		'curent_ssh_user' => $this->ssh->count(),
    		'curent_user_balance' => $this->user->balance,
            'curent_user_point' => $this->user->point,
    	]);
    }

    private function doPremiumTask($request,$type)
    {
 		// check if server available to create new user.
 		if($this->isServerAvailableToCreateNewAccount())
 		{
			// check username available.
    		if($this->isAccountAvailable($request->username,$type,$request->_server))
    		{
    			// check if balance or point meet the account prices.
    			if($request->pay == 'balance')
    			{
    				$price = $this->server->price * $request->duration;
	    			if($this->isBalanceMeet($price))
	    			{
	    				// create account!
	    				$this->price = $price;
	    				$this->username = $request->username;
	    				$this->password = $request->password;
	    				$this->duration = $request->duration;

	    				if($type == 'vpn')
                        {
                            return $this->doCreateVPN();
                        }

                        return $this->doCreateSSH();
	    			}

	    			return $this->flashMessage('error', [
		    			'status' => 'Error Balance',
		    			'data' => [
		    				'reason' => 'Your Balance not meet the account price'
		    			],
                        'message' => ($this->user->admin) ? $this->message->pesan_saldo_tidak_cukup_admin : $this->message->pesan_saldo_tidak_cukup,
		    		]);
    			}

    			$price = $this->server->price_point * $request->duration;
    			if($this->isPointMeet($price))
    			{
    				// create account!
    				$this->price = $price;
    				$this->username = $request->username;
    				$this->password = $request->password;
    				$this->duration = $request->duration;

                    if($type == 'vpn')
                    {
                        return $this->doCreateVPN();
                    }

    				return $this->doCreateSSH();
    			}

    			return $this->flashMessage('error', [
	    			'status' => 'Error Point',
	    			'data' => [
	    				'reason' => 'Your Point not meet the account price'
	    			]
	    		]);
    		}

    		return $this->flashMessage('error', [
                'status' => 'Error',
                'data' => [
                    'reason' => 'Username already used!'
                ]
            ]);
 		}

 		return $this->flashMessage('error', [
			'status' => 'Error',
			'data' => [
				'reason' => 'Whoops! Unable to create Account, Please try again later!'
			]
		]);
 	}

    private function doTrialTask($request,$type)
    {
        // set the duration.
        $this->duration = 'trial';

        if($this->isAllowedTrial())
        {
            if($this->isServerAvailableToCreateNewAccount())
            {
                if($this->isAccountAvailable($request->username,$type,$request->_server))
                {
                    // set the username and password.
                    $this->username = $request->username;
                    $this->password = $request->password;

                    if($type == 'vpn')
                    {
                        return $this->doCreateVPN();
                    }

                    return $this->doCreateSSH();
                }

                return $this->flashMessage('error', [
                    'status' => 'Error',
                    'data' => [
                        'reason' => 'Username already used!'
                    ]
                ]);
            }

            return $this->flashMessage('error', [
                'status' => 'Error',
                'data' => [
                    'reason' => 'Whoops! Unable to create Account, Please try again later!'
                ]
            ]);
        }

        return $this->flashMessage('error', [
            'status' => 'Trial Limit',
            'data' => [
                'reason' => 'Trial daily limit reached!'
            ]
        ]);
    }

    private function checkAdmin()
    {
    	if($this->user->role == 'admin')
    	{
    		return true;
    	}

    	return false;
    }


    private function isAllowedTrial()
    {
    	$trial = Trial::where('reseller_email', $this->user->email)
                     -> where('create_date', date('d-m-Y'))->count();
        if($trial >= 5)
        {
            return true;
        }

        return true;
    }

    private function isServerExistsById($id)
    {
    	$server = Server::find($id);
    	if(!$server)
    	{
    		return false;
    	}

    	return true;
    }

    private function isServerExistsByIP($ip)
    {
    	$server = Server::where('ip',$ip);
    	if(!$server)
    	{
    		return false;
    	}

    	return true;
    }

    private function isAccountAvailable($username,$type,$server)
    {

        if($type == 'vpn')
    	{
    		// vpn user
    		$user = Vpn::where('username', $username)
    		          -> where('at_server', $server)->first();

    		if(!$user)
    		{
    			return true;
    		}

    		return false;
    	}
    	else
    	{
    		// ssh user
    		$user = Ssh::where('username', $username)
    		          -> where('at_server', $server)->first();

    		if(!$user)
    		{
    			return true;
    		}

    		return false;
    	}
    }

    private function isBalanceMeet($price)
    {
    	if($this->user->balance >= $price)
    	{
    		return true;
    	}

    	return false;
    }

    private function isPointMeet($price)
    {
    	if($this->user->point >= $price)
    	{
    		return true;
    	}

    	return false;
    }

    private function isServerAvailableToCreateNewAccount()
    {
    	if($this->server->user_created >= $this->server->limit_day)
    	{
    		return false;
    	}

    	return true;
    }

    private function flashMessage($status,$message = [])
    {
    	if($status == 'success')
    	{
    		return response()->json($message,200);
    	}

    	return response()->json($message,500);
    }

    private function cutBalance($cut)
    {
        if($this->user->role != 'admin')
        {
           User::where('email', $this->user->email)->decrement('balance', $cut);
           return true;
        }

        return true;
    }

    public function listSSH()
    {
        
        if($this->user->role == 'admin') {
            $ssh = Ssh::where('status', '!=', 'trial')->get();
        }
        else 
        {
            $ssh = Ssh::where('reseller_email', $this->user->email)
                 -> where('status', '!=', 'trial')->get();
        }
        

        return view('global.ssh-list')->with('sshs', $ssh);
    }

    public function deleteSSH($id)
    {
        $ssh = Ssh::where('id', $id)->first();
        if(!$ssh)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }


        if($this->user->role == 'admin') {
            $server = Server::where('ip', $ssh->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            $cmd->exec('userdel ' . $ssh->username);
            Ssh::where('username', $ssh->username)->delete();
            return $this->flashMessage('success', ['status' => true]);
        }


        if($ssh->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $ssh->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            $cmd->exec('userdel ' . $ssh->username);
            Ssh::where('username', $ssh->username)->delete();
            return $this->flashMessage('success', ['status' => true]);
        }

        return $this->flashMessage('error', ['status' => 'error']);
    }

    public function lockSSH($id)
    {
        $ssh = Ssh::where('id', $id)->first();
        if(!$ssh)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($ssh->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $ssh->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', []);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', []);
            }

            $cmd->exec('passwd -l ' . $ssh->username);
            Ssh::where('id', $ssh->id)->update(['status' => 'locked']);
            return $this->flashMessage('success', []);
        }

        return $this->flashMessage('error', []);
    }

    public function unlockSSH($id)
    {
        $ssh = Ssh::where('id', $id)->first();
        if(!$ssh)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($ssh->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $ssh->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', []);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', []);
            }

            $cmd->exec('passwd -u ' . $ssh->username);
            Ssh::where('id', $ssh->id)->update(['status' => 'active']);
            return $this->flashMessage('success', []);
        }

        return $this->flashMessage('error', []);
    }


    function changeSSHPassword(Request $request,$id)
    {
        $ssh = Ssh::where('id', $id)->first();
        if(!$ssh)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($ssh->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $ssh->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', []);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', []);
            }

            $cmd->exec('echo ' . $ssh->username . ':' . $request->password . ' | chpasswd');
            return $this->flashMessage('success', []);
        }

        return $this->flashMessage('error', []);
    }


    /**
     *             VPN SECTION
     * ------>>>>>>>> |||||| <<<<<<<<-------
     *
     */

    public function createVPN(Request $request)
    {
        $message = [
            "captcha.required" => 'The :attribute field is required.',
            "captcha.captcha" => 'The entering :attribute value does not match server response.'
        ];

        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
            'duration' => 'required'
        ],$message);

        $this->note = $request->note;

        if($validator->fails())
        {
            return response()->json([
                'response' => 'Validation Error',
                'data' => [
                    'reason' => 'Some error detected.',
                    'error' => json_decode($validator->errors())
                ]
            ],422);
        }

        if($this->isServerExistsByIP($request->_server))
        {
            $this->server = Server::where('ip',$request->_server)->first();
        }
        else
        {
            return $this->flashMessage('error', [
                'status' => 'Error',
                'data' => [
                    'reason' => 'Server you are trying to create account does not exists.'
                ]
            ]);
        }

        if($this->checkAdmin())
        {
            return ($request->duration == 'trial')
              ? $this->doTrialTask($request, 'vpn')
              : $this->doPremiumTask($request, 'vpn');
        }

        if($request->duration == 'trial')
        {
            return $this->doTrialTask($request,'vpn');
        }

        return $this->doPremiumTask($request,'vpn');
    }

    private function doCreateVPN()
    {
        $server = $this->server;

        $ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return view('global.server-not-connect');
        }

        if($this->duration == 'trial')
        {
            
            if(is_null($server->vpn_software)) {
                $ssh->exec('useradd ' . $this->username . ' -m -s /bin/false');
                $ssh->exec('echo ' . $this->username . ':' . $this->password . ' | chpasswd');
            }
            else 
            {
                if($server->vpn_software->type == 'l2tp') {
                    $ssh->exec('echo "\"' . $this->username . '\" l2tpd \"' . $this->password . '\" *" >> /etc/ppp/chap-secrets');
                    $ssh->exec('echo "' . $this->username . ':$(openssl passwd -1 "' . $this->password . '"):xauth-psk" >> /etc/ipsec.d/passwd');
                }
                else 
                {
                    $ssh->exec('useradd ' . $this->username . ' -m -s /bin/false');
                    $ssh->exec('echo ' . $this->username . ':' . $this->password . ' | chpasswd');
                }
            }

            
            // updating database record.

            // updating trial count.
            Trial::create([
                'reseller_email' => $this->user->email,
                'create_date' => date('d-m-Y'),
            ]);

            // updating ssh user.
            Vpn::create([
                'username' => $this->username,
                'reseller_email' => $this->user->email,
                'at_server' => $this->server->ip,
                'status' => 'trial',
                'expired_on' => date('d-m-Y'),
            ]);

            // updating logs table.
            Log::create([
                'task_name' => 'Trial VPN Account Successfully created!',
                'message' => $this->user->name . ' Successfully create trial SSH Account on ' . date('d-m-Y'),
                'triggerer' => $this->user->email,
            ]);

            $this->trialCount = Trial::where('reseller_email', $this->user->email)->count();
            $this->trialPercent = $this->trialCount / 5 * 100;

            return $this->flashMessage('success', [
                'status' => 'Trial Success',
                'details' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'host' => $this->server->ip,
                ],
                'message' => ($this->user->role == 'admin') ? $this->message->pesan_trial_sukses_admin : $this->message->pesan_trial_sukses,
                'trial_account' => $this->trialCount,
                'percent' => $this->trialPercent,
            ]);
        }


        if(is_null($server->vpn_software)) {
            $ssh->exec('useradd -e `date -d "' . $this->duration . ' months" +"%Y-%m-%d"` -m -s /bin/false ' . $this->username);
            $ssh->exec('echo ' . $this->username . ':' . $this->password . ' | chpasswd');
        }
        else 
        {
            if($server->vpn_software->type == 'l2tp') {
                $ssh->exec('echo "\"' . $this->username . '\" l2tpd \"' . $this->password . '\" *" >> /etc/ppp/chap-secrets');
                $ssh->exec('echo "' . $this->username . ':$(openssl passwd -1 "' . $this->password . '"):xauth-psk" >> /etc/ipsec.d/passwd');
            }
            else 
            {
                $ssh->exec('useradd -e `date -d "' . $this->duration . ' months" +"%Y-%m-%d"` -m -s /bin/false ' . $this->username);
                $ssh->exec('echo ' . $this->username . ':' . $this->password . ' | chpasswd');

            }
        }

        // updating database record.
        $vpnAccount = Vpn::create([
            'username' => $this->username,
            'reseller_email' => $this->user->email,
            'at_server' => $this->server->ip,
            'status' => 'active',
            'expired_on' => $this->now->addMonths($this->duration),
        ]);

        // updatin servers record.
        Server::where('ip', $this->server->ip)->increment('user_created');

        // updating logs table.
        Log::create([
            'task_name' => 'VPN Account Successfully created!',
            'message' => $this->user->name . ' Successfully create VPN Account on ' . date('d-m-Y') . ' Active until ' . $this->now->addMonths($this->duration),
            'triggerer' => $this->user->email,
        ]);

        Notes::create([
            'account_id' => $vpnAccount->id,
            'content' => $this->note
        ]);

        // decrements balance & incrementing points.
        $this->cutBalance($this->price);
        User::where('id', $this->user->id)->increment('point', $this->server->points * $this->duration);
        $this->vpn = Vpn::where('reseller_email', $this->user->email);
        $this->user = User::where('email', $this->user->email)->first();

        return $this->flashMessage('success', [
            'status' => 'Ok',
            'details' => [
                'username' => $this->username,
                'password' => $this->password,
                'host' => $this->server->ip,
                'psk' => (is_null($this->server->vpn_software)) ? '' : $this->server->vpn_software->l2tp_password
            ],
            'message' => ($this->user->role == 'admin') ? $this->message->pesan_vpn_sukses_admin : $this->message->pesan_vpn_sukses,
            'curent_vpn_user' => $this->vpn->count(),
            'curent_user_balance' => $this->user->balance,
            'curent_user_point' => $this->user->point,
        ]);
    }

    public function listVPN()
    {
        if($this->user->role == 'admin') {
            $vpn = Vpn::where('status', '!=', 'trial')->get();
        }
        else 
        {
            $vpn = Vpn::where('reseller_email', $this->user->email)
                 -> where('status', '!=', 'trial')->get();
        }

        return view('global.vpn-list')->with('vpns', $vpn);
    }

    public function deleteVPN($id)
    {
        $vpn = Vpn::where('id', $id)->first();
        if(!$vpn)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($this->user->role == 'admin') {
            $server = Server::where('ip', $vpn->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            if(is_null($server->vpn_software)) {
                $cmd->exec('userdel ' . $vpn->username);
                Vpn::where('username', $vpn->username)->delete(); 
            }
            else 
            {
                if($server->vpn_software->type == 'l2tp') {
                    $cmd->exec('sed -r -i "/\"' . $vpn->username . '\"/g" /etc/ppp/chap-secrets >> /etc/ppp/chap-secrets');
                    $cmd->exec('sed -r -i "/' . $vpn->username . '\:/g" /etc/ipsec.d/passwd >> /etc/ipsec.d/passwd');
                    Vpn::where('username', $vpn->username)->delete();
                }
                else 
                {
                    $cmd->exec('userdel ' . $vpn->username);
                    Vpn::where('username', $vpn->username)->delete();
                }
            }

            return $this->flashMessage('success', ['status' => true]);
        }

        if($vpn->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $vpn->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', ['status' => 'error']);
            }

            if(is_null($server->vpn_software)) {
               $cmd->exec('userdel ' . $vpn->username);
                Vpn::where('username', $vpn->username)->delete(); 
            }
            else 
            {
                if($server->vpn_software->type == 'l2tp') {
                    $cmd->exec('sed -r -i "/\"' . $vpn->username . '\"/g" /etc/ppp/chap-secrets >> /etc/ppp/chap-secrets');
                    $cmd->exec('sed -r -i "/' . $vpn->username . '\:/g" /etc/ipsec.d/passwd >> /etc/ipsec.d/passwd');
                    Vpn::where('username', $vpn->username)->delete();
                }
                else 
                {
                    $cmd->exec('userdel ' . $vpn->username);
                    Vpn::where('username', $vpn->username)->delete();
                }
            }

            return $this->flashMessage('success', ['status' => true]);
        }

        return $this->flashMessage('error', ['status' => 'error']);
    }

    public function lockVPN($id)
    {
        $vpn = Vpn::where('id', $id)->first();
        if(!$vpn)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($vpn->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $vpn->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', []);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', []);
            }

            $cmd->exec('passwd -l ' . $vpn->username);
            Vpn::where('id', $vpn->id)->update(['status' => 'locked']);
            return $this->flashMessage('success', []);
        }

        return $this->flashMessage('error', []);
    }

    public function unlockVPN($id)
    {
        $vpn = Vpn::where('id', $id)->first();
        if(!$vpn)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($vpn->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $vpn->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', []);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', []);
            }

            $cmd->exec('passwd -u ' . $vpn->username);
            Vpn::where('id', $vpn->id)->update(['status' => 'active']);
            return $this->flashMessage('success', []);
        }

        return $this->flashMessage('error', []);
    }


    function changeVPNPassword(Request $request,$id)
    {
        $vpn = Vpn::where('id', $id)->first();
        if(!$vpn)
        {
            return $this->flashMessage('error', ['status' => 'error']);
        }

        if($vpn->reseller_email == $this->user->email)
        {
            $server = Server::where('ip', $vpn->at_server)->first();
            if(!$server)
            {
                return $this->flashMessage('error', []);
            }

            $cmd = new SSH2($server->ip);
            if(!$cmd->login($server->user,decrypt($server->pass)))
            {
                return $this->flashMessage('error', []);
            }

            $cmd->exec('echo ' . $vpn->username . ':' . $request->password . ' | chpasswd');
            return $this->flashMessage('success', []);
        }

        return $this->flashMessage('error', []);
    }

    public function editSSH($id)
    {
        $account = Ssh::where('id', $id)->first();
        if(!$account){
            echo "

                <div class='alert alert-danger'>
                    Whoops! Something went wrong!
                </div>

            ";
            return;
        }

        if(is_null($account->note)) {
            $note = "";
        }
        else
        {
            $note = $account->note->content;
        }

        echo '
            <form method="post" action="/ssh/create" id="edit-ssh">


                <input type="hidden" name="_token" id="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_id" id="_id" value="' . $account->id . '">
                <input type="hidden" name="_server" id="_server" value="' . $account->at_server . '">

                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="username" type="text" class="form-control" value="' . $account->username . '" required>
                                <label class="form-label">User</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="password" type="password" class="form-control">
                                <label class="form-label">Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <textarea class="form-control" rows="3" name="note">
                                ' . $note . '
                                </textarea>
                                <label class="form-label " style="top: -10px !important;">Notes</label>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="col-sm-12">
                        <button onclick="editSSH()" type="submit" id="btn-edit-ssh" class="btn bg-teal waves-effect">EDIT</button>
                    </div>
                </div>
        </form>
        ';

        return;

    }

    public function editVPN($id)
    {
        $account = Vpn::where('id', $id)->first();
        if(!$account){
            echo "

                <div class='alert alert-danger'>
                    Whoops! Something went wrong!
                </div>

            ";
            return;
        }

        if(is_null($account->note)) {
            $note = "";
        }
        else
        {
            $note = $account->note->content;
        }

        echo '
            <form method="post" action="/vpn/create" id="edit-vpn">


                <input type="hidden" name="_token" id="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_id" id="_id" value="' . $account->id . '">
                <input type="hidden" name="_server" id="_server" value="' . $account->at_server . '">

                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="username" type="text" class="form-control" value="' . $account->username . '" required>
                                <label class="form-label">User</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input name="password" type="password" class="form-control">
                                <label class="form-label">Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <textarea class="form-control" rows="3" name="note">' . $note . '</textarea>
                                <label class="form-label" style="top: -10px !important;">Notes</label>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="col-sm-12">
                        <button onclick="editVPN()" type="submit" id="btn-edit-vpn" class="btn bg-teal waves-effect">EDIT</button>
                    </div>
                </div>
        </form>
        ';

        return;
    }

    public function doEditSSH(Request $request)
    {
        $account = Ssh::where('id', $request->_id)->first();
        if(!$account)
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        $server = Server::where('ip', $account->at_server)->first();

        $ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        $ssh->exec('usermod -l ' . $request->username . ' ' . $account->username);
        $ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');

        Ssh::where('id', $request->_id)->update([
            'username' => $request->username
        ]);

        Notes::where('account_id', $request->_id)->update([
            'content' => $request->note
        ]);

        return;
    }

    public function doEditVPN(Request $request)
    {
        $account = Vpn::where('id', $request->_id)->first();
        if(!$account)
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        $server = Server::where('ip', $account->at_server)->first();

        $ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        $ssh->exec('usermod -l ' . $request->username . ' ' . $account->username);
        $ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');

        Vpn::where('id', $request->_id)->update([
            'username' => $request->username
        ]);

        Notes::where('account_id', $request->_id)->update([
            'content' => $request->note
        ]);

        return;
    }

    public function editActiveSSH($id)
    {
        $account = Ssh::where('id', $id)->first();
        return '
            <form method="post" action="/vpn/create" id="ssh-active">

                <input type="hidden" name="_token" id="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_server" id="_server" value="' . $account->at_server . '">
                <input type="hidden" name="_id" id="_id" value="' . $account->id . '">

                <div class="row clearfix">

                    <div class="alert alert-info">
                        This action will add new active date to this user.
                    </div>

                    <div class="col-sm-12 col-lg-12">
                        <select class="form-control show-tick" name="duration">
                            <option value="1">Add 1 Month</option>
                            <option value="2">Add 2 Month</option>
                            <option value="3">Add 3 Month</option>
                            <option value="4">Add 4 Month</option>
                            <option value="5">Add 5 Month</option>
                            <option value="6">Add 6 Month</option>
                            <option value="7">Add 7 Month</option>
                            <option value="8">Add 8 Month</option>
                            <option value="9">Add 9 Month</option>
                            <option value="10">Add 10 Month</option>
                            <option value="11">Add 11 Month</option>
                            <option value="12">Add 12 Month</option>
                        </select>
                    </div>

                    <hr />

                    <div class="col-sm-12">
                        <button onclick="changeSSHActiveDate()" type="submit" id="btn-change-ssh-active" class="btn bg-teal waves-effect">CREATE</button>
                    </div>
                </div>
        </form>
        ';
    }

    public function editActiveVPN($id)
    {
        $account = Vpn::where('id', $id)->first();
        return '
            <form method="post" action="/vpn/create" id="vpn-active">

                <input type="hidden" name="_token" id="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_server" id="_server" value="' . $account->at_server . '">
                <input type="hidden" name="_id" id="_id" value="' . $account->id . '">

                <div class="row clearfix">

                    <div class="alert alert-info">
                        This action will add new active date to this user.
                    </div>

                    <div class="col-sm-12 col-lg-12">
                        <select class="form-control show-tick" name="duration">
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

                    <hr />

                    <div class="col-sm-12">
                        <button onclick="changeVPNActiveDate()" type="submit" id="btn-change-vpn-active" class="btn bg-teal waves-effect">CREATE</button>
                    </div>
                </div>
        </form>
        ';
    }

    public function doEditActiveSSH(Request $request)
    {
        $account = Ssh::where('id', $request->_id)->first();
        if(!$account){
            return response()->json([
                'success' => false,
            ],500);
        }

        $server = Server::where('ip', $account->at_server)->first();
        if(!$server){
            return response()->json([
                'success' => false,
            ],500);
        }

        $price = $server->price * $request->duration ;
        if($this->user->balance < $price){
            return response()->json([
                'success' => false,
            ],500);
        }

        $ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        // $duration = $request->duration + 1;
        $duration = Carbon::parse($account->expired_on)->addMonths($request->duration);
        $h = $ssh->exec('chage -E ' . $duration->format('Y-m-d') . ' ' . $account->username);

        Ssh::where('id', $request->_id)->update([
            'expired_on' => $duration,
        ]);

        User::where('email', $this->user->email)->decrement('balance', $price);

        return;
    }

    public function doEditActiveVPN(Request $request)
    {
        $account = Vpn::where('id', $request->_id)->first();
        if(!$account){
            return response()->json([
                'success' => false,
            ],500);
        }

        $server = Server::where('ip', $account->at_server)->first();
        if(!$server){
            return response()->json([
                'success' => false,
            ],500);
        }

        $price = $server->price * $request->duration;
        if($this->user->balance < $price){
            return response()->json([
                'success' => false,
            ],500);
        }

        $ssh = new SSH2($server->ip);
        if(!$ssh->login($server->user,decrypt($server->pass)))
        {
            return response()->json([
                'success' => false,
            ],500);
        }

        $duration = Carbon::parse($account->expired_on)->addMonths($request->duration);
        $h = $ssh->exec('chage -E ' . $duration->format('Y-m-d') . ' ' . $account->username);

        Vpn::where('id', $request->_id)->update([
            'expired_on' => $duration,
        ]);

        User::where('email', $this->user->email)->decrement('balance', $price);

        return;
    }

}
