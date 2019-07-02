<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Machine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_device');
        Schema::dropIfExists('m_device_translation');
        Schema::dropIfExists('m_area');
        Schema::dropIfExists('m_area_translation');
        Schema::dropIfExists('m_site');
        Schema::dropIfExists('m_site_translation');
        Schema::enableForeignKeyConstraints(); 

        Schema::create('m_site', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('point')->nullable()->comment('1,2;3,4');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_site_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('Name site');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_area', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->nullable()->unsigned();
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_area_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('Tên khu vực');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_device', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->nullable()->unsigned();
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_device_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('Tên máy');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::table('m_device', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('m_area');
        });

        Schema::table('m_device_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_device');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_area', function (Blueprint $table) {
            $table->foreign('site_id')->references('id')->on('m_site');
        });

        Schema::table('m_area_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_area');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_site_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_site');
            $table->foreign('language_id')->references('id')->on('config_language');
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
        Schema::dropIfExists('m_device');
        Schema::dropIfExists('m_device_translation');
        Schema::dropIfExists('m_area');
        Schema::dropIfExists('m_area_translation');
        Schema::dropIfExists('m_site');
        Schema::dropIfExists('m_site_translation');
        Schema::enableForeignKeyConstraints();  
    }
}
