<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = ['name' => 'admin', 'display_name' => 'Administrator','multiple_management' => 0, 'description' => 'Administrator role'];
        $role = Role::create($role);
        $permission_data = Models\Permission::get();
        foreach ($permission_data as $key => $value) {
            $role->attachPermission($value);
        }

        $role1 = ['name' => 'owner', 'display_name' => 'Owner','multiple_management' => 0, 'description' => 'Owner role'];
        $role1 = Role::create($role1);

        $role2 = ['name' => 'supervisor', 'display_name' => 'Supervisor','multiple_management' => 1, 'description' => 'Supervisor role'];
        $role2 = Role::create($role2);
    }
}
