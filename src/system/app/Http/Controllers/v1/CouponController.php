<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gift;
use Validator;
use Auth;

class CouponController extends Controller
{

    public $user;

    public function __construct() {
      $this->middleware('adminApi', ['except' => ['reedem']]);
      $this->user = Auth::guard('api')->user();
    }

    public function index() {
      return response()->json([
        'error' => false,
        'code' => 200,
        'message' => 'OK',
        'details' => Gift::get()->toArray(),
        'trace' => '#' . str_random(5),
      ], 200, [], JSON_PRETTY_PRINT);
    }

    public function create(Request $request) {
      $rules = [
        'code' => 'required',
        'amount' => 'required|integer',
        'message' => 'required'
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

      $coupon = Gift::where('code', $request->code)->first();
      if($coupon) {
        return response()->json([
          'error' => true,
          'code' => 422,
          'message' => 'Unprocessable Entity',
          'details' => [
            'severity' => 'Info!',
            'reason' => 'The provided resource was exists',
          ],
          'trace' => '#' . str_random(5)
        ],422,[], JSON_PRETTY_PRINT);
      }

      $coupon = Gift::create([
          'code' => $request->code,
          'amount' => $request->amount,
          'messages' => $request->message,
          'is_reedemed' => false,
      ]);

      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => $coupon,
          'trace' => '#' . str_random(5)
      ], 200, [], JSON_PRETTY_PRINT);

    }

    public function reedem(Request $request) {

        $rules = [
            'code' => 'required'
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

        $coupon = Gift::where('code', $request->code)->where('is_reedemed', false)->first();
        if(!$coupon) {
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

        $query = $this->user->update([
            'balance' => $coupon->amount + $this->user->balance
        ]);

        $coupon->update([
            'is_reedemed' => true,
            'reedemed_by' => $this->user->email,
            'reedemed_at' => \Carbon\Carbon::now(),
        ]);

        return response()->json([
            'error' => false,
            'code' => 200,
            'message' => 'OK',
            'details' => [
              'message' => $coupon->messages,
              'query' => $query
            ],
            'trace' => '#' . str_random(5)
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id) {
      $coupon = Gift::find($id);
      if(!$coupon) {
        return response()->json([
            'error' => true,
            'code' => 400,
            'message' => 'Not Found',
            'details' => [
              'severity' => 'Info',
              'reason' => 'The specified resource was not found.'
            ],
        ], 404, [], JSON_PRETTY_PRINT);
      }

      $coupon->delete();
      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => [
              'severity' => 'OK',
              'reason' => 'The provided resource was processed successfully'
          ],
          'trace' => '#' . str_random(5)
      ], 200, [], JSON_PRETTY_PRINT);
    }
}
