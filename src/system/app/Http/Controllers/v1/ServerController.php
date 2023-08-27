<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Server;
use Validator;

class ServerController extends Controller
{
    public function __construct() {
      $this->middleware('adminApi');
    }

    public function index() {
      $resource = Server::get();

      return \Response::json($resource->toArray(), 200, [], JSON_PRETTY_PRINT);
    }

    public function read($id) {
      $server = Server::find($id);
      if(!$server) {
        return response()->json([
          'error' => true,
          'code' => 404,
          'message' => 'Not Found',
          'details' => [
              'severity' => 'Warning',
              'reason' => 'The specified resource was not found!'
          ],
          'trace' => '#' . str_random(5)
        ]);
      }

      return response()->json([
        'error' => false,
        'code' => 200,
        'message' => 'OK',
        'details' => $server->toArray(),
        'trace' => '#' . str_random(5)

      ]);

    }

    public function create(Request $request) {

        $rules = [
            'name' => 'required',
            'ip' => 'required|ip',
            'user' => 'required',
            'password' => 'required',
            'country' => 'required',
            'daily_limit' => 'required|integer',
            'point' => 'required|integer',
            'price_by_point' => 'required|integer',
            'price'
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

      $server = Server::where('ip', $request->ip)->first();
      if($server) {
          return response()->json([
            'error' => true,
            'code' => 422,
            'message' => 'Unprocessable Entity',
            'details' => [
              'severity' => 'Info!',
              'reason' => 'The Provided resource was exists.',
            ],
            'trace' => '#' . str_random(5)
          ],422,[], JSON_PRETTY_PRINT);
      }

      // insert
      $server = Server::create([
          'name' => $request->name,
          'ip' => $request->ip,
          'user' => $request->user,
          'pass' => encrypt($request->password),
          'country' => $request->country,
          'type' => $request->type,
          'limit' => 0,
          'limit_day' => $request->daily_limit,
          'user_created' => 0,
          'total_user' => 0,
          'points' => $request->point,
          'price' => $request->price,
          'price_point' => $request->price_by_point
      ]);

      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => [
              'severity' => 'OK!',
              'reason' => 'The Provided resource was successfully processed!'
          ],
          'resource' => [
              'id' => $server->id,
              'address' => request()->getHttpHost() . '/api/v1/server/' . $server->id,
          ],
          'trace' => '#' . str_random(5)
      ]);

    }

    public function update(Request $request, $id) {
        $server = Server::find($id);
        if(!$server) {
          return response()->json([
            'error' => true,
            'code' => 404,
            'message' => 'Not Found',
            'details' => [
                'severity' => 'Warning',
                'reason' => 'The specified resource was not found!'
            ],
            'trace' => '#' . str_random(5)
          ]);
        }

        $rules = [
            'name' => 'required',
            'ip' => 'required|ip',
            'user' => 'required',
            'password' => 'required',
            'country' => 'required',
            'daily_limit' => 'required|integer',
            'point' => 'required|integer',
            'price_by_point' => 'required|integer',
            'price'
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

        $server = Server::where('id', $id)->update([
          'name' => $request->name,
          'ip' => $request->ip,
          'user' => $request->user,
          'pass' => encrypt($request->password),
          'country' => $request->country,
          'type' => $request->type,
          'limit' => $server->limit,
          'limit_day' => $request->daily_limit,
          'user_created' => $server->user_created,
          'total_user' => $server->total_user,
          'points' => $request->point,
          'price' => $request->price,
          'price_point' => $request->price_by_point
        ]);

        return response()->json([
            'error' => false,
            'code' => 200,
            'message' => 'OK',
            'details' => [
                'severity' => 'OK!',
                'reason' => 'The Provided resource was successfully processed!'
            ],
            'resource' => [
                'id' => $id,
                'address' => request()->getHttpHost() . '/api/v1/server/' . $id,
            ],
            'trace' => '#' . str_random(5)
        ]);
    }

    public function destroy($id) {
      $server = Server::find($id);
      if(!$server) {
        return response()->json([
          'error' => true,
          'code' => 404,
          'message' => 'Not Found',
          'details' => [
              'severity' => 'Warning',
              'reason' => 'The specified resource was not found!'
          ],
          'trace' => '#' . str_random(5)
        ]);
      }

      $server->delete();
      return response()->json([
          'error' => false,
          'code' => 200,
          'message' => 'OK',
          'details' => [
              'severity' => 'OK!',
              'reason' => 'The Provided resource was successfully processed!'
          ],
          'trace' => '#' . str_random(5)
      ]);

    }
}
