<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Pesan;
use App\Admin;
use App\Feature;
use Validator;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function changeDetails(Request $request) {
        $rules = [
    		'username' => 'required',
    		'email' => 'required|email',
    		'password' => 'required'
    	];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        User::where('id', Auth::user()->id)->update([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back()->with('success', 'Your information updated successfully!');
    }

    public function changeWebsiteDetails(Request $request) {
        $rules = [
            'site_name' => 'required',
            'site_url' => 'required|url',
            'site_author' => 'required',
            'site_title' => 'required',
            'cf_email' => 'required',
            'cf_api' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Admin::where('id', 1)->update([
            'cf_email_key' => $request->cf_email,
            'cf_api_key' => $request->cf_api,
            'site_title' => $request->site_title,
            'site_author' => $request->site_author,
            'site_url' => $request->site_url,
            'site_name' => $request->site_name
        ]);

        return redirect()->back()->with('success', 'Site information changed successfully!');
    }

    public function changeMessage(Request $request) {
        $rules = [
            'ssh_success' => 'required',
            'ssh_failed' => 'required',
            'vpn_success' => 'required',
            'vpn_failed' => 'required',
            'trial_success' => 'required',
            'trial_failed' => 'required',
            'balance_min' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Pesan::where('id', 1)->update([
            'pesan_ssh_sukses' => $request->ssh_success,
            'pesan_ssh_gagal' => $request->ssh_failed,
            'pesan_vpn_sukses' => $request->vpn_success,
            'pesan_vpn_gagal' => $request->vpn_failed,
            'pesan_trial_sukses' => $request->trial_success,
            'pesan_trial_gagal' => $request->trial_failed,
            'pesan_saldo_tidak_cukup' => $request->balance_min
        ]);

        return redirect()->back()->with('success', 'Messages changed successfully!');
    }

    public function features() {
        return view('admin.features');
    }

    public function enableFeature($id) {
        $feature = Feature::where('id', $id);
        if(!$feature->first()) {
            return abort(500);
        }

        $feature->update(['status' => true]);
        return;
    }

    public function disableFeature($id) {
        $feature = Feature::where('id', $id);
        if(!$feature->first()) {
            return abort(500);
        }

        $feature->update(['status' => false]);
        return;
    }
}
