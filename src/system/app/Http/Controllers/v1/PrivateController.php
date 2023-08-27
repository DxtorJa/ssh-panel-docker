<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class PrivateController extends Controller
{
    public function login(Request $request) {
        // return $request;
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
          return response()->json([
              'error' => true,
              'code' => 401,
              'message' => 'Unauthorized',
              'details' => [
                  'severity' => 'Warning!',
                  'reason' => 'The JSON Payload doesn\'t meet the endpoint validation rules.'
              ]
          ], 401, [], JSON_PRETTY_PRINT);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
          return response()->json([
              'error' => true,
              'code' => 401,
              'message' => 'Unauthorized',
              'details' => [
                  'severity' => 'Warning!',
                  'reason' => 'Email or Password error.'
              ]
          ], 401, [], JSON_PRETTY_PRINT);
        }

        // user exists and we need to confirm the password.
        if(Hash::check($request->password, $user->password))
        {
            return response()->json([
                'error' => false,
                'code' => 200,
                'message' => 'OK',
                'details' => [
                    'severity' => 'Info',
                    'reason' => 'Successfully Logged In',
                    'details' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'balance' => $user->balance,
                        'point' => $user->point,
                        'image' => $user->images,
                        'lock' => $user->lock,
                        'suspend' => $user->suspend,
                        'api_token' => $user->api_token,
                        'id' => $user->id,
                        'role' => $user->role,
                    ],
                ],
                'trace' => '#' . str_random(5)
            ], 200, [], JSON_PRETTY_PRINT);
        }

        return response()->json([
            'error' => true,
            'code' => 401,
            'message' => 'Unauthorized',
            'details' => [
                'severity' => 'Warning!',
                'reason' => 'Email or Password error.'
            ]
        ], 401, [], JSON_PRETTY_PRINT);
    }
}
