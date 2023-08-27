<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class SellerController extends Controller
{
    public function index() {
      return response()->json([
        'error' => false,
        'code' => 200,
        'message' => 'OK',
        'details' => User::where('role', '!=', 'admin')->get()->toArray(),
        'trace' => '#' . str_random(5)
      ], 200, [], JSON_PRETTY_PRINT);
    }

    public function create(Request $request) {
      $rules = [
          'name' => 'required',
          'email' => 'required|email',
          'password' => 'required',
          'balance' => 'required|integer'
      ];

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()) {
        return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
                'severity' => 'Warning!',
                'reason' => 'The JSON Payload doesn\'t meet the validation rules.'
            ],
            'trace' => '#' . str_random(5)
        ], 422, [], JSON_PRETTY_PRINT);
      }

      $user = User::where('email', $request->email)->first();
      if($user) {
        return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
                'severity' => 'Info',
                'reason' => 'The specified resource was exists'
            ],
            'trace' => '#' . str_random(5)
        ], 422, [], JSON_PRETTY_PRINT);
      }

      $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'balance' => $request->balance,
          'role' => 'reseller',
          'images' => 'http://lorempixel.com/200/200/cats/',
          'point' => 0,
          'lock' => false,
          'suspend' => false,
          'api_token' => str_random(60)
      ]);

      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => [
              'severity' => 'OK',
              'details' => $user
          ],
          'trace' => '#' . str_random(5)
      ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id) {
      $user = User::find($id);
      if(!$user) {
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

      $user->delete();
      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => [
              'severity' => 'OK',
              'details' => $user
          ],
          'trace' => '#' . str_random(5)
      ], 200, [], JSON_PRETTY_PRINT);
    }
}
