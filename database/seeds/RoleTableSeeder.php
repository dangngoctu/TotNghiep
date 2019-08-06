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

        $role1 = ['name' => 'hr', 'display_name' => 'Human Resources','multiple_management' => 0, 'description' => 'Human Resources Role'];
        $role1 = Role::create($role1);

        $role2 = ['name' => 'owner', 'display_name' => 'Owner','multiple_management' => 1, 'description' => 'Owner Role'];
        $role2 = Role::create($role2);

        $role2 = ['name' => 'manager', 'display_name' => 'Manager','multiple_management' => 1, 'description' => 'Manager Role'];
        $role2 = Role::create($role2);
    }
}
