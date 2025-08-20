<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user and sample users
        $this->call([
            AdminUserSeeder::class,
            NewsSeeder::class,
            FaqSeeder::class,
            BookSeeder::class,
        ]);
    }
}
