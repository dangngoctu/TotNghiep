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
            //Site
            [
                'name' => 'admin_major',
                'display_name' => 'Major management in webpage',
                'description' => 'Major management in webpage'
            ],
            //Area
             [
                'name' => 'admin_course',
                'display_name' => 'Course management in webpage',
                'description' => 'Course management in webpage'
            ],
            //Device
            [
                'name' => 'admin_class',
                'display_name' => 'Class management in webpage',
                'description' => 'Class management in webpage'
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
                'name' => 'admin_graduation',
                'display_name' => 'Graduation management in webpage',
                'description' => 'Graduation management in webpage'
            ]
        ];
        DB::table('permissions')->insert($permission);
    
    }
}
