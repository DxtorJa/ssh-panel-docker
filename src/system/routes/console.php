<?php

use Illuminate\Foundation\Inspiring;
use App\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('create', function(){
	$name = $this->ask('Name ');
	$email = $this->ask('Email ');
	$pass = $this->ask('Password ');
	$role = $this->choice('Role ', ['admin', 'reseller', 'trial']);
	$balance = $this->ask('Balance ');

	echo $role;

	User::create([
		'name' => $name,
		'email' => $email,
		'password' => bcrypt($pass),
		'role' => $role,
		'balance' => $balance,
	]);

	$this->info('User created successfully!');
});

Artisan::command('migrate:fresh', function(){
	return Artisan::call('migrate:refresh');
});
