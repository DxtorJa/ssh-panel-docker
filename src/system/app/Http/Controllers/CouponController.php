<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gift;
use App\User;
use App\Notif;
use Validator;

class CouponController extends Controller
{
    
	public function index()
	{
		$reedemed = Gift::where('is_reedemed', true)->get();
		$unreedemed = Gift::where('is_reedemed', false)->get();

		return view('admin.coupon-index')
			-> with('reedemed', $reedemed)
			-> with('unreedemed', $unreedemed);
	}

	public function generate(Request $request)
	{
		$code = strtoupper(str_random(4) . '-' . str_random(4) . '-' . str_random(4) . '-' . str_random(4) . '-' . str_random(4));
		
		$validator = Validator::make($request->all(), [
			'amount' => 'numeric|required',
			'messages' => 'required'
		]);

		if($validator->fails())
		{
			return response()->json([
				'error' => $validator,
			],500);
		}

		Gift::create([
			'code' => $code,
			'amount' => $request->amount,
			'messages' => $request->messages,
			'is_reedemed' => 0,
		]);

		return response()->json([
			'ok' => 'ok'
		],200);
	}

	public function deposit(Request $request)
	{
		$user = User::where('email', $request->reseller)->first();
		if(!$user)
		{
			return abort(404);
		}

		User::where('email', $user->email)->increment('balance', $request->amount);
		
		Notif::create([
			'user_email' => $user->email,
			'message' => 'Successfully add balance ' . $request->amount,
			'color' => 'bg-green',
			'icons' => 'attach_money',
			'callback' => 'null'
		]);

		return response()->json([
			'status' => 'ok',
			'data' => [
				'reseller' => $user->name,
				'balance_plus' => $request->amount,
				'balance_before' => $user->balance,
				'balance_after' => $user->balance + $request->amount
			]
		],200);
	}

	public function create(Request $request)
	{
		
		Gift::create([
			'code' => $request->coupon_code,
			'amount' => $request->amount,
			'messages' => $request->message,
			'is_reedemed' => 0,
		]);

		$data = Gift::where('code', $request->coupon_code)->first();

		return response()->json([
			'success' => true,
			'data' => [
				'id' => $data->id,
				'code' => $data->code,
				'amount' => $data->amount,
				'message' => str_limit($data->messages,20),
				'created_at' => $data->created_at
			]
		],200);
	}

	public function remove(Request $request)
	{
		$coupon = Gift::where('id', $request->id)->first();
		if(!$coupon)
		{
			return response()->json([
				'success' => false,
			],500);
		}

		Gift::where('id', $request->id)->delete();
		return response()->json([
			'success' => true,
		]);
	}


}
