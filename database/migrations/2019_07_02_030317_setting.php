<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Setting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_setting');
        Schema::dropIfExists('system_management');
        Schema::enableForeignKeyConstraints();
        Schema::create('m_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo', 255)->nullable()->comment('logo');
            $table->string('default_password', 255)->nullable();
            $table->tinyInteger('limit_upload')->default(10)->comment('MB');
            $table->string('phone', 20)->unique()->comment('Phone hotline');
            $table->string('GG_KEY_MAP', 255)->comment('Google key map');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('system_management', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('line_id')->nullable()->unsigned();
            $table->integer('area_id')->nullable()->unsigned();
            $table->integer('device_id')->nullable()->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::table('system_management', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('area_id')->references('id')->on('m_area');
            $table->foreign('line_id')->references('id')->on('m_line');
            $table->foreign('device_id')->references('id')->on('m_device');
        });

        Schema::create('logtime', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->timestamp('time_in')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('time_out')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('hash', 255)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::table('logtime', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_setting');
        Schema::dropIfExists('system_management');
        Schema::enableForeignKeyConstraints();
    }
}
