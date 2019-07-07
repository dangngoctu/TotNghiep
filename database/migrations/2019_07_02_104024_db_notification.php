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
        Schema::dropIfExists('m_graduation');
        Schema::dropIfExists('m_graduation_category');
        Schema::enableForeignKeyConstraints();
        
        Schema::create('m_graduation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('teacher');
            $table->integer('student_id')->unsigned()->comment('student');
            $table->string('file', 255)->nullable();
            $table->integer('presentation_score');
            $table->integer('graduation_score');
            $table->integer('final_score');
            $table->string('comment', 255)->nullable();
            $table->tinyInteger('status')->comment('1: pass, 2 need fix, 3: fail');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::create('m_graduation_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('graduation_id')->unsigned()->comment('graduation_id');
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('failure_id')->nullable()->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::table('m_graduation', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->foreign('student_id')->references('id')->on('m_student');
        });

        Schema::table('m_graduation_category', function (Blueprint $table) {
            $table->foreign('graduation_id')->references('id')->on('m_graduation');
            $table->foreign('category_id')->references('id')->on('m_categories');
            $table->foreign('failure_id')->references('id')->on('m_falure_mode');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {Schema::dropIfExists('m_graduation_category');
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_graduation');
        
        Schema::enableForeignKeyConstraints();
    }
}
