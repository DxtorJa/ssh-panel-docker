<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vpn;
use App\Ssh;
use App\Dns;
use Auth;
use Validator;

class UserController extends Controller
{
    public function index()
    {
    	$details = User::where('email', Auth::user()->email)->first();
    	$sshs = Ssh::where('reseller_email', Auth::user()->email)->get();
    	$vpns = Vpn::where('reseller_email', Auth::user()->email)->get();
    	$dns = Dns::where('reseller_email', Auth::user()->email)->get();
    
    	return view('global.profile')
    		-> with('details', $details)
    		-> with('sshs', $sshs)
    		-> with('vpns', $vpns)
    		-> with('dns', $dns);
    }

    public function changeImage(Request $request)
    {
    		
    	$rules = [
    		'images' => 'required|image'
    	];

    	$validator = Validator::make($request->all(),$rules);

    	if($validator->fails())
    	{
    		return view('global.profile')
    			-> withErrors($validator);
    	}

    	$user = Auth::user();

    	$file = $request->file('images');
    	$profile = $user->id . '-profile-' . str_random(50) . '.' . $file->getClientOriginalExtension();
    	$file->move('user-images', $profile);

    	User::where('id', $user->id)->update([
    		'images' => '/user-images/' . $profile
    	]);

    	return redirect('/profile')->with('success', 'Image successfully changed!');
    }

    public function changeDetails(Request $request)
    {
    	$rules = [
    		'username' => 'required',
    		'email' => 'required|email',
    		'password' => 'required'
    	];

    	$validator = Validator::make($request->all(),$rules);

    	if($validator->fails())
    	{
    		return response()->json([
    			'succes' => false,
    		],500);
    	}

    	User::where('email', Auth::user()->email)->update([
    		'name' => $request->username,
    		'email' => $request->email,
    		'password' => bcrypt($request->password)
    	]);

    	$user = Auth::user();

    	return response()->json([
    		'success' => true,
    		'details' => [
    			'username' => $user->name,
    			'email' => $user->email
    		]
    	]);
    }
}
