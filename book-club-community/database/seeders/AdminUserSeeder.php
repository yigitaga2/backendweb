<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the default admin user as specified in requirements
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'is_admin' => true,
            'about_me' => 'Default administrator account for the Book Club Community platform.',
            'email_verified_at' => now(),
        ]);

        // Create a few sample regular users for testing
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'birthday' => '1990-05-15',
            'about_me' => 'Book lover and avid reader. Enjoys fantasy and science fiction novels.',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'birthday' => '1985-08-22',
            'about_me' => 'Literature enthusiast with a passion for classic novels and poetry.',
            'email_verified_at' => now(),
        ]);
    }
}
