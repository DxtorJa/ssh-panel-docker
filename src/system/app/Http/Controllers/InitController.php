<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Pesan;
use Validator;

class InitController extends Controller
{
    public function __construct()
    {
    	$this->middleware('installMiddleware');
    }

    public function install(Request $request)
    {
    	$message = [
    		'username.required' => 'Username is required.',
    		'email.required' => 'Email is required.',
    		'email.email' => 'Email is should be an Email format.',
    		'site_name.required' => 'Site Name is required.',
    		'site_title.required' => 'Site Title is required.',
    		'site_url.required' => 'Site URL is required.',
    		'site_url.url' => 'Site URL should be a URL.',
    		'site_author.required' => 'Site Author is required.',
    		'site_description.required' => 'Site Description is required.',
    		'site_banner.required' => 'Site Image Banner is required.',
    		'site_banner.image' => 'Site Image Banner should be an image file.',
            'ssh_success' => 'Message if success create ssh is required.',
            'ssh_failed' => 'Message if failed create ssh is required.',
            'vpn_success' => 'Message if success create vpn is required.',
            'vpn_failed' => 'Message if failed create vpn is required.',
            'trial_success' => 'Message if success create trial is required.',
            'trial_failed' => 'Message if failed create trial is required.',
            'balance_min' => 'Message if balance lower than price is required.',

            'ssh_success_admin' => 'Message if success create ssh is required.',
            'ssh_failed_admin' => 'Message if failed create ssh is required.',
            'vpn_success_admin' => 'Message if success create vpn is required.',
            'vpn_failed_admin' => 'Message if failed create vpn is required.',
            'trial_success_admin' => 'Message if success create trial is required.',
            'trial_failed_admin' => 'Message if failed create trial is required.',
            'balance_min_admin' => 'Message if balance lower than price is required.',

    	];
    	$validator = Validator::make($request->all(),[
    		'username' => 'required',
    		'email' => 'required|email',
    		'password' => 'required',
    		'site_name' => 'required',
    		'site_title' => 'required',
    		'site_url' => 'required|url',
    		'site_author' => 'required',
    		'site_description' => 'required',
    		'site_banner' => 'required|image',
            'ssh_success' => 'required',
            'ssh_failed' => 'required',
            'vpn_success' => 'required',
            'vpn_failed' => 'required',
            'trial_success' => 'required',
            'trial_failed' => 'required',
            'balance_min' => 'required',
            'cloudflare_email' => 'required',
            'cloudflare_key' => 'required',
            'ssh_success_admin' => 'required',
            'ssh_failed_admin' => 'required',
            'vpn_success_admin' => 'required',
            'vpn_failed_admin' => 'required',
            'trial_success_admin' => 'required',
            'trial_failed_admin' => 'required',
            'balance_min_admin' => 'required',
    	],$message);

    	if($validator->fails()){
    		return view('install')->withErrors($validator);
    	}

    	$file = $request->file('site_banner');
    	$site_banner = 'site_banner.' . $file->getClientOriginalExtension();
    	$file->move('user-images', $site_banner);

    	Admin::create([
    		'cf_email_key' => $request->cloudflare_email,
    		'cf_api_key' => $request->cloudflare_key,
    		'setting_up' => true,
    		'site_name' => $request->site_name,
    		'site_title' => $request->site_title,
    		'site_description' => $request->site_description,
    		'site_author' => $request->site_author,
    		'site_url' => $request->site_url,
    		'site_thumbnails' => 'user-images/' . $site_banner,
    	]);

    	User::create([
    		'name' => $request->username,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    		'role' => 'admin',
    		'balance' => 99999999999,
    		'images' => 'https://picsum.photos/200/200?image=' . rand(1,9),
        'api_token' => str_random(62),
    	]);

        Pesan::create([
            'pesan_ssh_sukses' => $request->ssh_success,
            'pesan_ssh_gagal' => $request->ssh_failed,
            'pesan_vpn_sukses' => $request->vpn_success,
            'pesan_vpn_gagal' => $request->vpn_failed,
            'pesan_trial_sukses' => $request->trial_success_admin,
            'pesan_trial_gagal' => $request->trial_failed_admin,
            'pesan_saldo_tidak_cukup' => $request->balance_min_admin,
            'pesan_ssh_sukses_admin' => $request->ssh_success_admin,
            'pesan_ssh_gagal_admin' => $request->ssh_failed_admin,
            'pesan_vpn_sukses_admin' => $request->vpn_success_admin,
            'pesan_vpn_gagal_admin' => $request->vpn_failed_admin,
            'pesan_trial_sukses_admin' => $request->trial_success_admin,
            'pesan_trial_gagal_admin' => $request->trial_failed_admin,
            'pesan_saldo_tidak_cukup_admin' => $request->balance_min_admin
        ]);

    	return redirect('/login');
    }
}
