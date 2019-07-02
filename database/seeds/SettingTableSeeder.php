<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('m_setting')->insert([
            [
                'default_password' => '1234', 
                'limit_upload' => 3 ,
                'phone'=> '0990033668',
                'GG_KEY_MAP' => 'AIzaSyCgckjWdlD5EvdCSb68pDxkxWeiUHFqKtc'
            ]
        ]);
    }
}
