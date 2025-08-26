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
        // Check if admin exists
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'name'     => 'Admin',
                'username' => 'admin',
                'email'    => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]);
        }

        // Check if normal user exists
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
