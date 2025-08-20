<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('is_admin', true)->first();

        if (!$admin) {
            return; // No admin user found
        }

        // Create sample news articles
        \App\Models\News::updateOrCreate(
            ['slug' => 'welcome-to-book-club-community'],
            [
                'title' => 'Welcome to Book Club Community!',
                'content' => '<p>We are excited to launch our new Book Club Community platform! Here you can discover new books, share reviews, and connect with fellow book lovers.</p><p>Features include:</p><ul><li>Personal library management</li><li>Book reviews and ratings</li><li>Community discussions</li><li>Reading recommendations</li></ul>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now(),
            ]
        );

        \App\Models\News::updateOrCreate(
            ['slug' => 'monthly-book-recommendations'],
            [
                'title' => 'Monthly Book Recommendations - January 2025',
                'content' => '<p>Our community has been buzzing with great book recommendations this month! Here are some of the top picks:</p><h3>Fiction</h3><ul><li>"The Seven Husbands of Evelyn Hugo" by Taylor Jenkins Reid</li><li>"Where the Crawdads Sing" by Delia Owens</li></ul><h3>Non-Fiction</h3><ul><li>"Atomic Habits" by James Clear</li><li>"Educated" by Tara Westover</li></ul><p>Happy reading!</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ]
        );

        \App\Models\News::updateOrCreate(
            ['slug' => 'reading-challenge-2025'],
            [
                'title' => 'Join Our 2025 Reading Challenge!',
                'content' => '<p>Set your reading goals for 2025! Whether you want to read 12 books or 52, we have challenges for every reader.</p><p>How to participate:</p><ol><li>Set your reading goal in your profile</li><li>Track your progress in your library</li><li>Share your reviews to inspire others</li><li>Connect with other participants</li></ol><p>Prizes will be awarded for various milestones throughout the year!</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ]
        );
    }
}
