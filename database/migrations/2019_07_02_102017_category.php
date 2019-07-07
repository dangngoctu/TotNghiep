<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Category extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_falure_mode_translation');
        Schema::dropIfExists('m_falure_mode');
        Schema::dropIfExists('m_categories_translation');
        Schema::dropIfExists('m_categories');
        Schema::enableForeignKeyConstraints();

        Schema::create('m_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_categories_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 255)->nullable()->comment('Mô tả');
            $table->string('name', 255)->nullable()->comment('name of category');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_falure_mode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable()->unsigned();
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_falure_mode_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('name of falure mode');
            $table->integer('translation_id')->nullable()->unsigned();
            $table->integer('language_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });



        Schema::table('m_falure_mode_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_falure_mode');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_categories_translation', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('m_categories');
            $table->foreign('language_id')->references('id')->on('config_language');
        });

        Schema::table('m_falure_mode', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('m_categories');
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
        Schema::dropIfExists('m_falure_mode_translation');
        Schema::dropIfExists('m_falure_mode');
        Schema::dropIfExists('m_categories_translation');
        Schema::dropIfExists('m_categories');
        Schema::enableForeignKeyConstraints();
    }
}
