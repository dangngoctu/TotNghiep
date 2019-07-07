<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Student extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_student');
        Schema::enableForeignKeyConstraints();


        Schema::create('m_student', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('mssv')->unique();
            $table->string('name', 128)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('class_id')->unsigned();
            $table->date('dob')->default('1980-01-01')->nullable();
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        Schema::table('m_student', function (Blueprint $table) {
            $table->foreign('class_id')->references('id')->on('m_class');
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
        Schema::dropIfExists('m_student');
        Schema::enableForeignKeyConstraints();
    }
}
