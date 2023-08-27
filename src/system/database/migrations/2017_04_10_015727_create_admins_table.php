<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cf_email_key');
            $table->string('cf_api_key');
            $table->boolean('setting_up');
            $table->string('site_title');
            $table->string('site_name');
            $table->string('site_author');
            $table->string('site_url');
            $table->text('site_description');
            $table->text('site_thumbnails');
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
        Schema::dropIfExists('admins');
    }
}
