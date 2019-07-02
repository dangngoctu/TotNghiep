<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_user');
        Schema::dropIfExists('config_language');
        Schema::enableForeignKeyConstraints();

        Schema::create('m_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 20)->unique();
            $table->string('password', 128);
            $table->string('email')->unique();
            $table->string('name', 128)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('fcm_token', 255)->nullable();
            $table->date('dob')->default('1980-01-01')->nullable();
            $table->timestamp('time_update_password')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('time update password');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái: (1) Kích hoạt, (0) Tắt');
            $table->tinyInteger('is_online')->default(1)->comment('1: Push; 0: No push');
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_user');
        Schema::dropIfExists('config_language');
        Schema::enableForeignKeyConstraints();
    }
}
