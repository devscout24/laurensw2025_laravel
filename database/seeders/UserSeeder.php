<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'], // unique field to check
            [
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['username' => 'user'], // unique field to check
            [
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );
    }
}
