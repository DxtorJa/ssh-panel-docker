//  	if($request->duration == '-- Select Duration --')
   //  	{
   //  		return redirect('/');
   //  	}

   //  	$server   = Server::where('ip', $request->_server)->first();
   //  	$reseller = Auth::user();
   //  	$pesan    = Pesan::where('id', 1)->first();
   //  	$now	  = Carbon::now();

   //  	if(!$server)
   //  	{
   //  		return response()->json([
   //  			'status' => 'Error',
   //  			'data' => [
   //  				'reason' => 'No server found.'
   //  			]
   //  		],404);
   //  	}

   //  	if($server->limit_day == $server->user_created)
   //  	{
   //  		return response()->json([
   //  			'status' => 'Error',
   //  			'data' => [
   //  				'reason' => 'Server daily limit reached!'
   //  			]
   //  		]);
   //  	}

   //  	//validate form submit

   //  	$message = [
   //  		"captcha.required" => 'The :attribute field is required.',
   //  		"captcha.captcha" => 'The entering :attribute value does not match server response.'
   //  	];

   //  	$validator = Validator::make($request->all(),[
   //  		'username' => 'required',
   //  		'password' => 'required',
   //  		'captcha' => 'required|captcha',
   //  		'duration' => 'required'
   //  	],$message);

   //  	if($validator->fails())
   //  	{
   //  		return response()->json([
   //  			'response' => 'Validation Error',
   //  			'data' => [
   //  				'reason' => 'Some error detected.',
   //  				'error' => json_decode($validator->errors())
   //  			]
   //  		],422);
   //  	}

   //  	$ssh = new SSH2($server->ip);
   //  	if(!$ssh->login($server->user,$server->pass))
   //  	{
   //  		return response()->json([
   //  			'status' => 'Error',
   //  			'data' => [
   //  				'reason' => 'Unable to connect server.'
   //  			]
   //  		],500);
   //  	}

   //  	$user = Ssh::where('username', $request->username)->where('at_server', $request->_server)->first();

   //  	if(!$user)
   //  	{
   //  		// handle trial account.
	  //   	if($request->duration == 'trial')
	  //   	{
	  //   		if($reseller->role == 'reseller')
	  //   		{
	  //   			if(Trial::where('reseller_email', $reseller->email)->where('create_date', date('d-m-Y'))->count() > 4)
	  //   			{
	  //   				return response()->json([
	  //   					'status' => 'Trial Limit',
	  //   					'data' => [
	  //   						'reason' => 'Trial request reach limitation.',
	  //   						'message' => $pesan->pesan_trial_gagal,
	  //   					]
	  //   				],401);
	  //   			}

	  //   			$ssh->exec('useradd ' . $request->username . ' -m -s /bin/false');
	  //   			$ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');
	    			
	  //   			Trial::create([
	  //   				'reseller_email' => $reseller->email,
	  //   				'create_date' => date('d-m-Y'),
	  //   			]);

	  //   			Ssh::create([
	  //   				'reseller_email' => $reseller->email,
	  //   				'username' => $request->username,
	  //   				'at_server' => $server->ip,
	  //   				'status' => 'trial',
	  //   				'expired_on' => date('d-m-Y'),
	  //   			]);

	  //   			// count new percent
	  //   			$newTrial   = Trial::where('reseller_email', $reseller->email)->count();
	  //   			$newPercent = $newTrial / 5 * 100;

	  //   			return response()->json([
	  //   				'status' => 'Trial Success',
	  //   				'details' => [
	  //   					'username' => $request->username,
	  //   					'password' => $request->password,
	  //   					'host' => $server->ip,
	  //   				],
	  //   				'message' => $pesan->pesan_trial_sukses,
	  //   				'user_details' => [
	  //   					'percent' => $newPercent,
	  //   					'trial_account' => $newTrial,
	  //   				]
	  //   			]);
	  //   		}
	  //   		else
	  //   		{
	  //   			$ssh->exec('useradd ' . $request->username . ' -m -s /bin/false');
	  //   			$ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');
	  //   			Trial::create([
	  //   				'reseller_email' => $reseller->email,
	  //   				'create_date' => date('d-m-Y'),
	  //   			]);
	  //   			Ssh::create([
	  //   				'reseller_email' => $reseller->email,
	  //   				'username' => $request->username,
	  //   				'at_server' => $server->ip,
	  //   				'status' => 'active',
	  //   				'expired_on' => date('d-m-Y'),
	  //   			]);
	  //   			Notif::create([
	  //   				'user_email' => $reseller->email,
	  //   				'message' => 'Trial SSH Account successfully created.',
	  //   				'color' => 'bg-green',
	  //   				'icons' => 'check',
	  //   				'callback' => 'null'
	  //   			]);
	  //   			Notif::create([
	  //   				'user_email' => User::where('role','admin')->first()->email,
	  //   				'message' => $reseller->name . ' Successfully create Trial SSH Account.',
	  //   				'color' => 'bg-green',
	  //   				'icons' => 'check',
	  //   				'callback' => 'null'
	  //   			]);

	  //   			// count new percent
	  //   			$newTrial   = Trial::where('reseller_email', $reseller->email)->count();
	  //   			$newPercent = round($newTrial / 5 * 100);
	  //   			return response()->json([
			// 			'status' => 'Trial Success',
			// 			'details' => [
			// 				'username' => $request->username,
			// 				'password' => $request->password,
			// 				'host' => $server->ip,
			// 			],
			// 			'message' => $pesan->pesan_trial_sukses,
			// 			'user_details' => [
			// 				'percent' => $newPercent,
			// 				'trial_account' => $newTrial,
			// 			]
			// 		]);
	  //   		}


	    		
	  //   	}

   //  		// user available.
   //  		if($reseller->role = 'reseller')
   //  		{
   //  			if($reseller->balance >= $server->price * $request->duration)
   //  			{
   //  				$ssh->exec('useradd -e `date -d "' . $request->duration . ' months" +"%Y-%m-%d"` -m -s /bin/false ' . $request->username);
	  //   			$ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');
	  //   			User::where('email', $reseller->email)->decrement('balance', $server->price * $request->duration);

	  //   			Ssh::create([
	  //   				'reseller_email' => $reseller->email,
	  //   				'username' => $request->username,
	  //   				'at_server' => $server->ip,
	  //   				'status' => 'active',
	  //   				'expired_on' => $now->addMonths($request->duration),
	  //   			]);
	  //   			Notif::create([
	  //   				'user_email' => $reseller->email,
	  //   				'message' => 'Your SSH Account successfully created.',
	  //   				'color' => 'bg-green',
	  //   				'icons' => 'check',
	  //   				'callback' => 'null'
	  //   			]);
	  //   			Notif::create([
	  //   				'user_email' => User::where('role','admin')->first()->email,
	  //   				'message' => $reseller->name . ' Successfully create SSH Account.',
	  //   				'color' => 'bg-green',
	  //   				'icons' => 'check',
	  //   				'callback' => 'null'
	  //   			]);

	  //   			// add server limit
	  //   			Server::where('ip', $server->ip)->increment('user_created');

	  //   			return response()->json([
	  //   				'status' => 'Ok',
	  //   				'details' => [
	  //   					'username' => $request->username,
	  //   					'password' => $request->password,
	  //   					'host' => $server->ip,
	  //   				],
	  //   				'message' => $pesan->pesan_ssh_sukses,
	  //   				'curent_ssh_user' => Ssh::where('reseller_email', $reseller->email)->count(),
	  //   				'curent_user_balance' => User::where('email', Auth::user()->email)->first()->balance,
	  //   			]);
   //  			}

   //  			// balance not meet
   //  			return response()->json([
   //  				'status' => 'Balance Insuficient',
   //  				'data' => [
   //  					'reason' => 'Your balance not meet the account prices.',
   //  					'message' => $pesan->pesan_saldo_tidak_cukup,
   //  				]
   //  			],406);
   //  		}

   //  		//admin

   //  		$ssh->exec('useradd -e `date -d "' . $request->duration . ' months" +"%Y-%m-%d"` -m -s /bin/false ' . $request->username);
			// $ssh->exec('echo ' . $request->username . ':' . $request->password . ' | chpasswd');

			// Ssh::create([
			// 	'reseller_email' => $reseller->email,
			// 	'username' => $request->username,
			// 	'at_server' => $server->ip,
			// 	'status' => 'active',
			// 	'expired_on' => $now->addMonths($request->duration),
			// ]);
			// Notif::create([
			// 	'user_email' => $reseller->email,
			// 	'message' => 'Your SSH Account successfully created.',
			// 	'color' => 'bg-green',
			// 	'icons' => 'check',
			// 	'callback' => 'null'
			// ]);
			// Notif::create([
			// 	'user_email' => User::where('role','admin')->first()->email,
			// 	'message' => $reseller->name . ' Successfully create SSH Account.',
			// 	'color' => 'bg-green',
			// 	'icons' => 'check',
			// 	'callback' => 'null'
			// ]);

			// // add user limit
	  //   	Server::where('ip', $server->ip)->increment('user_created');


			// return response()->json([
			// 	'status' => 'Ok',
			// 	'details' => [
			// 		'username' => $request->username,
			// 		'password' => $request->password,
			// 		'host' => $server->ip,
			// 	],
			// 	'message' => $pesan->pesan_ssh_sukses,
			// 	'curent_ssh_user' => Ssh::where('reseller_email', $reseller->email)->count(),
			// 	'curent_user_balance' => User::where('email', Auth::user()->email)->first()->balance,
			// ]);
   //  	}

   //  	return response()->json([
   //  		'status' => 'Error',
   //  		'data' => [
   //  			'reason' => 'Username already used!'
   //  		]
   //  	],401);