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
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Users
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['username' => 'user'],
            [
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );
    }
}
