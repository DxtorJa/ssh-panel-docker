<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use App\Cert;

class CertController extends Controller
{
    public function all() {
        $cert = Cert::get();

        return view('global.cert')->with('certs', $cert);
    }

    public function byIp($ip) {
        $server = Server::where('ip', $ip)->first();
        if(!$server) {
            return abort(404);
        }

        $certs = Cert::where('server_id', $server->id)->get();
        return view('global.cert')->with('certs', $certs);
    }

    public function add() {
        return view('admin.add-cert')->with('servers', Server::get());
    }

    public function upload(Request $request) {
        if($request->server_id == null || $request->server_id == 'null') {
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required',
            'port' => 'required',
            'cert' => 'required'
        ]);

        $uniq = str_random(5);
        $cert = $request->file('cert');
        $path = $cert->move('certs', $request->name . '-' . $request->port . '-' . $uniq . '.' . $cert->getClientOriginalExtension());
        $url  = url('/certs/' . $request->name . '-' . $request->port . '-' . $uniq . '.' . $cert->getClientOriginalExtension());
    
        Cert::create([
            'name' => $request->name,
            'port' => $request->port,
            'description' => 'fuck you',
            'server_id' => $request->server_id,
            'url' => $url
        ]);

        return redirect()->back()->with('message', 'Certificate successfully uploaded!');
    }

    public function deleteCert($id) {
        $cert = Cert::where('id', $id);

        if(!$cert->first()) {
            return abort(404);
        }

        $cert->delete();

        return response()->json([]);
    }
}
