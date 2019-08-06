<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            // WEBSITE
            [
                'name' => 'admin_login',
                'display_name' => 'Log in webpage',
                'description' => 'Log in webpage'
            ],
            // Setting
            [
                'name' => 'admin_setting',
                'display_name' => 'Setting management in webpage',
                'description' => 'Setting management in webpage'
            ],
            //Line
            [
                'name' => 'admin_line',
                'display_name' => 'Line management in webpage',
                'description' => 'Line management in webpage'
            ],
            //Area
             [
                'name' => 'admin_area',
                'display_name' => 'Area management in webpage',
                'description' => 'Area management in webpage'
            ],
            //Device
            [
                'name' => 'admin_machine',
                'display_name' => 'Machine management in webpage',
                'description' => 'Machine management in webpage'
            ],
            //Category
            [
                'name' => 'admin_category',
                'display_name' => 'Category management in webpage',
                'description' => 'Category management in webpage'
            ],
            //Falure mode
            [
                'name' => 'admin_failure',
                'display_name' => 'Failure management in webpage',
                'description' => 'Failure management in webpage'
            ],
            //Falure mode detail
            [
                'name' => 'admin_failure_detail',
                'display_name' => 'Failure details management in webpage',
                'description' => 'Failure details management in webpage'
            ],
            //Report management
            [
                'name' => 'admin_report',
                'display_name' => 'Report management in webpage',
                'description' => 'Report management in webpage'
            ],
            //User management
            [
                'name' => 'admin_user',
                'display_name' => 'User management in webpage',
                'description' => 'User management in webpage'
            ],
            //Role
            [
                'name' => 'admin_role',
                'display_name' => 'Role management in webpage',
                'description' => 'Role management in webpage'
            ],
            //Graduation
            [
                'name' => 'admin_notification',
                'display_name' => 'Notification management in webpage',
                'description' => 'Notification management in webpage'
            ],
        ];
        DB::table('permissions')->insert($permission);
    
    }
}
