<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $agentRole = Role::create(['name' => 'agent']);

        // Creating a new user
        $user = User::create([
            'name' => 'New User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Assigning a role to the user
        $user->assignRole($userRole);

        // Creating an admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Assigning the admin role to the user
        $admin->assignRole($adminRole);

        $agent = User::create([
            'name' => 'Agent User',
            'email' => 'agent@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Assigning the admin role to the user
        $agent->assignRole($agentRole);

    }
}
