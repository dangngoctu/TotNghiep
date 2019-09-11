<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_notificaiton');
        Schema::enableForeignKeyConstraints();
        
        Schema::create('m_notificaiton', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('creater');
            $table->integer('device_id')->unsigned()->comment('device_id');
            $table->string('file', 255)->nullable();
            $table->integer('category_id')->unsigned()->comment('category');
            $table->integer('failure_id')->unsigned()->comment('failure');
            $table->longtext('comment', 255)->nullable();
            $table->longtext('submit_comment', 255)->nullable();
            $table->tinyInteger('status')->comment('1: new, 2 confirm, 3: reject');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });


        Schema::table('m_notificaiton', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('category_id')->references('id')->on('m_categories');
            $table->foreign('failure_id')->references('id')->on('m_failure_mode');
            $table->foreign('device_id')->references('id')->on('m_device');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_notificaiton');
        Schema::enableForeignKeyConstraints();
    }
}
