<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name'=>'admin']);

        $permissions = [
            ['name' => 'User List'],
            ['name' => 'Create User'],
            ['name' => 'edit User'],
            ['name' => 'delete User'],
            ['name' => 'Role List'],
            ['name' => 'Create Role'],
            ['name' => 'edit Role'],
            ['name' => 'delete Role'],
        ];

        foreach($permissions as $item){
            Permission::create($item);
        }

        $role->syncPermissions(Permission::all());

        $user = User::first();
        $user->assignRole($role);
    }
}
