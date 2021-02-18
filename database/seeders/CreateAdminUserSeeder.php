<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Guru Super Admin',
            'email' => 'superadmin@guru.com',
            'password' => Hash::make('admin123'),
        ]);

        $role = Role::create(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $adminuser = User::create([
            'name' => 'Guru Admin',
            'email' => 'admin@guru.com',
            'password' => Hash::make('admin123'),
        ]);
        $roleadmin = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Teacher']);
        Role::create(['name' => 'Parent']);
        Role::create(['name' => 'Student']);
        $adminuser->assignRole([$roleadmin->id]);
    }
}
