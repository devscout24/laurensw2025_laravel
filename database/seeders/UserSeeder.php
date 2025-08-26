<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        if (!Role::where('name', 'admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }

        if (!Role::where('name', 'user')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'user', 'guard_name' => 'web']);
        }

        // Users
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'name'     => 'Admin',
                'username' => 'admin',
                'email'    => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]);
        }

        if (!User::where('username', 'user')->exists()) {
            User::create([
                'name'     => 'User',
                'username' => 'user',
                'email'    => 'user@user.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]);
        }
    }
}
