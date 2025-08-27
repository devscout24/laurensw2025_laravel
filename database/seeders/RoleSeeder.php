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
        // Check and create admin role
        if (!Role::where('name', 'admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'admin', 'guard_name' => 'web']);
            $this->command->info('Admin role created.');
        } else {
            $this->command->info('Admin role already exists.');
        }

        // Check and create user role
        if (!Role::where('name', 'user')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'user', 'guard_name' => 'web']);
            $this->command->info('User role created.');
        } else {
            $this->command->info('User role already exists.');
        }

        // Assign roles to users safely
        $admin_user = User::where('email', 'admin@admin.com')->first();
        if ($admin_user) {
            if (!$admin_user->hasRole('admin')) {
                $admin_user->assignRole('admin');
                $this->command->info('Admin role assigned to admin user.');
            } else {
                $this->command->info('Admin user already has admin role.');
            }
        }

        $user = User::where('email', 'user@user.com')->first();
        if ($user) {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
                $this->command->info('User role assigned to user.');
            } else {
                $this->command->info('User already has user role.');
            }
        }
    }
}
