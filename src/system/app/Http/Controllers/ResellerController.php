<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Trial;
use App\Vpn;
use App\Ssh;
use App\Dns;
use Auth;

class ResellerController extends Controller
{
    public function index()
    {
    	$reseller = User::where('role', 'reseller')->get();
    	return view('admin.reseller-create')->with('resellers', $reseller);
    }

    public function create(Request $request)
    {
    	$user  = User::where('email', $request->email)->first();
    	if(!$user)
    	{
    		User::create([
    			'name' => $request->username,
    			'email' => $request->email,
    			'password' => bcrypt($request->password),
    			'balance' => $request->balance,
    			'role' => 'reseller',
          'api_token' => str_random(60)
    		]);

    		return response()->json([
    			'success' => true,
    		]);
    	}

    	return response()->json([
			'success' => false,
		],500);
    }

    public function addBalance(Request $request,$id)
    {
    	$user = User::where('id', $id)->first();
        if(!$user)
        {
            return $this->flashMessage('error', []);
        }

        User::where('id', $id)->increment('balance', $request->balance);

        return $this->flashMessage('success', []);
    }

    public function delete($id)
    {
    	$user = User::where('id', $id)->first();
    	if(!$user)
    	{
    		return $this->flashMessage('error', []);
    	}

    	User::where('id', $id)->delete();
    	return $this->flashMessage('success', []);
    }

    public function list_reseller()
    {
    	$reseller = User::where('role', 'reseller')->get();

    	return view('admin.reseller-list')->with('resellers', $reseller);
    }

    private function flashMessage($status,$message = [])
    {
    	if($status == 'success')
    	{
    		return response()->json($message,200);
    	}

    	return response()->json($message,500);
    }

    public function edit($id)
    {
        $user = User::where('role', 'reseller')->where('id', $id)->first();
        if(!$user)
        {
            echo "
                <div class='alert alert-dager'>
                    Whoops! Something went wrong!.
                </div>
            ";

            return;
        }

        echo '
            <form method="post" id="add-reseller">
                ' . csrf_field() . '
                <input type="hidden" name="_id" value="' . $id . '">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="username" value="' . $user->name . '" required>
                                <label class="form-label">Username</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="email" class="form-control" name="email" value="' . $user->email . '" required>
                                <label class="form-label">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="balance" value="' . $user->balance . '" required>
                                <label class="form-label">Balance</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="password" class="form-control" name="password" required>
                                <label class="form-label">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <button type="submit" class="btn btn-success" onclick="editResellerOnModal();" id="btn-add-reseller">SAVE</button>

                        ' . $this->btnLock($id) . '
                        ' . $this->btnSuspend($id) . '


                    </div>
                </div>
            </form>
        ';

        return;
    }

    private function btnLock($id)
    {
        $user = User::where('id', $id)->first();
        if($user->lock)
        {
          return '<button id="unlock-reseller" type="button" class="btn btn-warning" onclick="unlockUserOnModal(' . $id . ');" data-toggle="tooltip" data-placement="top" title="Unlock Reseller">' . $this->userLockStatus($id) . '</button>';
        }

        return '<button id="lock-reseller" type="button" class="btn btn-warning" onclick="lockUserOnModal(' . $id . ');" data-toggle="tooltip" data-placement="top" title="Lock Reseller">' . $this->userLockStatus($id) . '</button>';

    }

    private function btnSuspend($id)
    {
        $user = User::where('id', $id)->first();
        if($user->suspend)
        {
            return '<button type="button" class="btn btn-danger" onclick="unsuspendUserOnModal(' . $id . ');" id="unsuspend-reseller" data-toggle="tooltip" data-placement="top" title="Unsuspend Reseller">' . $this->userSuspendStatus($id) . '</button>';
        }

        return '<button type="button" class="btn btn-danger" onclick="suspendUserOnModal(' . $id . ');" id="suspend-reseller" data-toggle="tooltip" data-placement="top" title="Suspend Reseller">' . $this->userSuspendStatus($id) . '</button>';
    }

    private function userLockStatus($id)
    {
        $user = User::where('id', $id)->first();

        if($user->lock)
        {
            return "UNLOCK";
        }

        return "LOCK";
    }

    private function userSuspendStatus($id)
    {
        $user = User::where('id', $id)->first();

        if($user->suspend)
        {
            return "UNSUSPEND";
        }

        return "SUSPEND";
    }


    public function change(Request $request)
    {
        $user = User::where('id', $request->_id)->first();

        if(!$user)
        {
            return response()->json([
                'success' => false
            ],500);
        }

        User::where('id', $request->_id)->update([
            'name' => $request->username,
            'email' => $request->email,
            'balance' => $request->balance,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function lock($id)
    {
        $user = User::where('id', $id)->first();
        if(!$user)
        {
            return response()->json([
                'success' => false
            ]);
        }

        if(Auth::user()->role != 'admin')
        {
            return response()->json([
                'success' => false
            ]);
        }

        User::where('id', $id)->update(['lock' => 1]);
        return response()->json([
            'success' => true
        ]);
    }

    public function unlock($id)
    {
        $user = User::where('id', $id)->first();
        if(!$user)
        {
            return response()->json([
                'success' => false
            ]);
        }

        if(Auth::user()->role != 'admin')
        {
            return response()->json([
                'success' => false
            ]);
        }

        User::where('id', $id)->update(['lock' => 0]);
        return response()->json([
            'success' => true
        ]);
    }

    public function suspend($id)
    {
        $user = User::where('id', $id)->first();
        if(!$user)
        {
            return response()->json([
                'success' => false
            ]);
        }

        if(Auth::user()->role != 'admin')
        {
            return response()->json([
                'success' => false
            ]);
        }

        User::where('id', $id)->update(['suspend' => 1]);
        return response()->json([
            'success' => true
        ]);
    }

    public function unsuspend($id)
    {
        $user = User::where('id', $id)->first();
        if(!$user)
        {
            return response()->json([
                'success' => false
            ]);
        }

        if(Auth::user()->role != 'admin')
        {
            return response()->json([
                'success' => false
            ]);
        }

        User::where('id', $id)->update(['suspend' => 0]);
        return response()->json([
            'success' => true
        ]);
    }
}
