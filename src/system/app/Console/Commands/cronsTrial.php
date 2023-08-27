<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Trial;
use phpseclib\Net\SSH2;
use App\Server;
use App\Ssh;
use App\Vpn;

class cronsTrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crons:trial';

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
      $sshUser = Ssh::where('status', 'trial')->get();
      foreach($sshUser as $ssh) {
        $server = Server::where('ip', $ssh->at_server)->first();
        $shell = new SSH2($server->ip);
        try {
          $shell->login($server->user, decrypt($server->pass));
        } catch (\Exception $e) {
          $this->info('Failed to connect server!');
        }

        $shell->exec('userdel ' . $ssh->username);
        Ssh::where('id', $ssh->id)->delete();
        $this->info('Trial account: ' . $ssh->username . ' deleted!');

        Trial::where('reseller_email', $ssh->reseller_email)->delete();

      }

      $vpnUser = Vpn::where('status', 'trial')->get();
      foreach($vpnUser as $vpn) {
        $server = Server::where('ip', $vpn->at_server)->first();
        $shell = new SSH2($server->ip);
        try {
          $shell->login($server->user, decrypt($server->pass));
        } catch (\Exception $e) {
          $this->info('Failed to connect server!');
        }

        $shell->exec('userdel ' . $vpn->username);
        Ssh::where('id', $vpn->id)->delete();
        $this->info('Trial account: ' . $vpn->username . ' deleted!');
        Trial::where('reseller_email', $vpn->reseller_email)->delete();


      }

      $this->info('Trial account cleared!');
    }
}
