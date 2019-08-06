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
        Schema::dropIfExists('config_language');
        Schema::dropIfExists('m_line');
        Schema::dropIfExists('m_line_translation');
        Schema::dropIfExists('m_area');
        Schema::dropIfExists('m_area_translation');
        Schema::dropIfExists('m_device');
        Schema::dropIfExists('m_device_translation');
        Schema::enableForeignKeyConstraints(); 

        Schema::create('config_language', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->comment('Tên ngôn ngữ');
            $table->string('code', 5)->comment('Mã ngôn ngữ: vn, en,...');
            $table->boolean('default')->default(false)->comment('Ngôn ngữ mặc định: true, false');
            $table->string('currency_code', 5)->comment('Mã tiền tệ: VND, USD,...');
            $table->string('date_format', 15)->comment('Định dạng ngày tháng');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_line', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_line_translation', function (Blueprint $table) {
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
            $table->integer('line_id')->nullable()->unsigned();
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
            $table->foreign('line_id')->references('id')->on('m_line');
        });

        Schema::table('m_area_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_area');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_line_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_line');
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
        Schema::dropIfExists('config_language');
        Schema::dropIfExists('m_line');
        Schema::dropIfExists('m_line_translation');
        Schema::dropIfExists('m_area');
        Schema::dropIfExists('m_area_translation');
        Schema::dropIfExists('m_device');
        Schema::dropIfExists('m_device_translation');
        Schema::enableForeignKeyConstraints();  
    }
}
