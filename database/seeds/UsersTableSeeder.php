<?php

use Illuminate\Database\Seeder;
use App\Models\MUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = MUser::create([
            'phone' => 'administrator',
            'password' => Hash::make('123456'),
            'email' => 'admin@admin.com',
            'name' => 'Administrator',
            'avatar' => null, 
            'fcm_token' => null, 
            'dob' => '1991-12-23', 
            'status' => 1,
            'is_online' => 0
        ]);

        for($i = 1; $i < 20; $i++){
            $admin = MUser::create([
                'phone' => '093734854'.$i,
                'password' => Hash::make('123456'),
                'email' => 'member'.$i.'@gmail.com',
                'name' => 'Member'.$i,
                'avatar' => null, 
                'fcm_token' => null, 
                'dob' => '1991-12-01', 
                'status' => 1,
                'is_online' => 0
            ]);
        }
    }
}
