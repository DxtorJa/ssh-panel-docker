<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ssh;
use App\Vpn;
use App\Server;

class crons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crons:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sshUser = Ssh::get();
        foreach($sshUser as $ssh) {
          if(substr($ssh->expired_on, 0, 10) == date('Y') . '-' . date('m') . '-' . date('d')) {
            $this->info($ssh->username . ' Expired! & Successfully deleted!');
            Ssh::where('id', $ssh->id)->delete();
          }
        }

        $vpnUser = Vpn::get();
        foreach($vpnUser as $vpn) {
          if(substr($vpn->expired_on, 0, 10) == date('Y') . '-' . date('m') . '-' . date('d')) {
            $this->info($vpn->username . ' Expired! & Successfully deleted!');
            Ssh::where('id', $vpn->id)->delete();
          }
        }

        $serverAll = Server::get();
        foreach($serverAll as $server) {
          $this->info($server->name . ' daily limit reseted!');
          Server::where('id', $server->id)->update(['user_created' => 0]);
          Server::where('id', $server->id)->update(['limit' => 0]);
        }

        $this->info('Crons succedded!');

    }
}
