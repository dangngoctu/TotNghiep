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
        Schema::dropIfExists('m_notification_image');
        Schema::dropIfExists('m_notification_action_image');
        Schema::dropIfExists('m_notification_action');
        Schema::dropIfExists('m_notification_time');
        Schema::dropIfExists('m_check_status');
        Schema::dropIfExists('m_notification');
        Schema::dropIfExists('system_management');
        Schema::enableForeignKeyConstraints();
        
        Schema::create('m_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('device_id')->nullable()->unsigned();
            $table->tinyInteger('priority')->nullable()->comment('Trạng thái: (1) Urgent, (2) Normal');
            $table->tinyInteger('evaluation')->nullable()->comment('Trạng thái: (1) Exl, (2) Good, (3) Averge, (4) Poor, (5) Very Poor');
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('falure_id')->nullable()->unsigned();
            $table->integer('falure_detail_id')->nullable()->unsigned();
            $table->timestamp('time_action')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Thoi gian action');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_notification_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_id')->unsigned();
            $table->string('url', 255)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_notification_action', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longtext('comment')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_notification_action_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_action_id')->unsigned();
            $table->string('url', 255)->nullable();
            $table->longtext('hash')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_notification_time', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_id')->unsigned();
            $table->tinyInteger('type')->nullable()->comment('1:seen; 2:done; 3:check ; 4:lock');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_check_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('notification_id')->nullable()->unsigned();
            $table->integer('status')->default(1)->nullable()->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::table('m_notification', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('device_id')->references('id')->on('m_device');
            $table->foreign('category_id')->references('id')->on('m_categories');
            $table->foreign('falure_id')->references('id')->on('m_falure_mode');
            $table->foreign('falure_detail_id')->references('id')->on('m_falure_mode_detail');
        });

        Schema::table('m_check_status', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('notification_id')->references('id')->on('m_notification');
        });

        Schema::table('m_notification_image', function (Blueprint $table) {
            $table->foreign('notification_id')->references('id')->on('m_notification');
        });

        Schema::table('m_notification_action', function (Blueprint $table) {
            $table->foreign('notification_id')->references('id')->on('m_notification');
            $table->foreign('user_id')->references('id')->on('m_user');
        });

        Schema::table('m_notification_action_image', function (Blueprint $table) {
            $table->foreign('notification_action_id')->references('id')->on('m_notification_action');
        });

        Schema::table('m_notification_time', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('notification_id')->references('id')->on('m_notification');
        });

        Schema::create('system_management', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('device_id')->nullable()->unsigned();
            $table->integer('area_id')->nullable()->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::table('system_management', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('area_id')->references('id')->on('m_area');
            $table->foreign('site_id')->references('id')->on('m_site');
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
        Schema::dropIfExists('m_notification_image');
        Schema::dropIfExists('m_notification_action_image');
        Schema::dropIfExists('m_notification_action');
        Schema::dropIfExists('m_notification_time');
        Schema::dropIfExists('m_check_status');
        Schema::dropIfExists('m_notification');
        Schema::dropIfExists('system_management');
        Schema::enableForeignKeyConstraints();
    }
}
