<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->increments('id');
            $table->text('pesan_ssh_sukses');
            $table->text('pesan_ssh_gagal');
            $table->text('pesan_vpn_sukses');
            $table->text('pesan_vpn_gagal');
            $table->text('pesan_trial_sukses');
            $table->text('pesan_trial_gagal');
            $table->text('pesan_saldo_tidak_cukup');
            $table->text('pesan_ssh_sukses_admin');
            $table->text('pesan_ssh_gagal_admin');
            $table->text('pesan_vpn_sukses_admin');
            $table->text('pesan_vpn_gagal_admin');
            $table->text('pesan_trial_sukses_admin');
            $table->text('pesan_trial_gagal_admin');
            $table->text('pesan_saldo_tidak_cukup_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesans');
    }
}
