<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        //User Assign admin role
        $admin_user = User::where('email', 'admin@admin.com')->first();
        if ($admin_user) {
            $admin_user->assignRole('admin');
        } else {
            $admin_user = User::create([
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678'),
            ]);
            $admin_user->assignRole('admin');
        }
        //User Assign user role
        $user = User::where('email', 'user@user.com')->first();
        if ($user) {
            $user->assignRole('user');
        } else {
            $admin_user = User::create([
                'name' => 'user',
                'username' => 'user',
                'email' => 'user@user.com',
                'password' => bcrypt('12345678'),
            ]);
            $admin_user->assignRole('user');
        }
    }
}
