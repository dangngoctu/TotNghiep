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
        Schema::enableForeignKeyConstraints();
        Schema::create('m_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('default_password', 255)->nullable();
            $table->tinyInteger('limit_upload')->default(3)->comment('MB');
            $table->string('phone', 20)->unique()->comment('Phone hotline');
            $table->string('GG_KEY_MAP', 255)->comment('Google key map');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
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
        Schema::enableForeignKeyConstraints();
    }
}
