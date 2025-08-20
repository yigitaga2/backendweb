<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample books if none exist
        if (\App\Models\Book::count() === 0) {
            \App\Models\Book::factory()->count(10)->create();
        }
    }
}
