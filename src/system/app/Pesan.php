<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = ['pesan_ssh_sukses','pesan_ssh_gagal', 'pesan_vpn_sukses','pesan_vpn_gagal','pesan_trial_sukses','pesan_trial_gagal','pesan_saldo_tidak_cukup','pesan_ssh_sukses_admin','pesan_ssh_gagal_admin', 'pesan_vpn_sukses_admin','pesan_vpn_gagal_admin','pesan_trial_sukses_admin','pesan_trial_gagal_admin','pesan_saldo_tidak_cukup_admin'];
}
