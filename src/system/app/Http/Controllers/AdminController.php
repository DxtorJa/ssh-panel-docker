<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Pesan;

class AdminController extends Controller
{
    public function __contruct()
    {
    	$this->middleware('adminMiddleware');
    }

    public function index()
    {
    	$admin = Admin::first();
    	$pesan = Pesan::first();

    	return view('admin.admin-setting')
    		-> with('admin', $admin)
    		-> with('pesan', $pesan);
    }
}
