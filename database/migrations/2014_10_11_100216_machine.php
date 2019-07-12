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
        Schema::dropIfExists('m_major');
        Schema::dropIfExists('m_major_translation');
        Schema::dropIfExists('m_course');
        Schema::dropIfExists('m_course_translation');
        Schema::dropIfExists('m_class');
        Schema::dropIfExists('m_class_translation');
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

        Schema::create('m_major', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_major_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('Name site');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('major_id')->nullable()->unsigned();
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_course_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('Tên khu vực');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_class', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->nullable()->unsigned();
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_class_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('Tên máy');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::table('m_class', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('m_course');
        });

        Schema::table('m_class_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_class');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_course', function (Blueprint $table) {
            $table->foreign('major_id')->references('id')->on('m_major');
        });

        Schema::table('m_course_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_course');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_major_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_major');
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
        Schema::dropIfExists('m_major');
        Schema::dropIfExists('m_major_translation');
        Schema::dropIfExists('m_course');
        Schema::dropIfExists('m_course_translation');
        Schema::dropIfExists('m_class');
        Schema::dropIfExists('m_class_translation');
        Schema::enableForeignKeyConstraints();  
    }
}
