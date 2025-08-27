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
        $adminExists = \App\Models\User::where('id', 1)->exists();
        $userExists = \App\Models\User::where('id', 2)->exists();

        if (!$adminExists) {
            \App\Models\User::create([
                'id' => 1,
                'name' => 'Mr. Admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'is_admin' => true,
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);
        }

        if (!$userExists) {
            \App\Models\User::create([
                'id' => 2,
                'name' => 'Mr. User',
                'username' => 'user',
                'email' => 'user@user.com',
                'is_admin' => false,
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);
        }

        if ($adminExists && $userExists) {
            $this->command->info('User/Admin already exist.');
        }
    }
}
