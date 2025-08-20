<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First create a default category
        $category = \App\Models\Category::updateOrCreate(
            ['name' => 'General'],
            ['description' => 'General questions about the platform']
        );

        // Create sample FAQ items
        \App\Models\Faq::updateOrCreate(
            ['question' => 'How do I add books to my library?'],
            [
                'answer' => 'You can add books to your library by browsing our book collection and clicking the "Add to Library" button on any book page. You can also create new book entries if the book you\'re looking for isn\'t in our database yet.',
                'category_id' => $category->id,
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'How do I write a book review?'],
            [
                'answer' => 'To write a review, go to any book\'s detail page and scroll down to the review section. You can rate the book with 1-5 stars and optionally write a detailed review to share your thoughts with the community.',
                'category_id' => $category->id,
                'sort_order' => 2,
                'is_published' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'Can I edit or delete my reviews?'],
            [
                'answer' => 'Yes! You can edit or delete your own reviews at any time. Simply go to the book page where you left the review and use the edit or delete options next to your review.',
                'category_id' => $category->id,
                'sort_order' => 3,
                'is_published' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'How do I track my reading progress?'],
            [
                'answer' => 'Your personal library allows you to track books with three statuses: "Want to Read", "Currently Reading", and "Read". You can change the status of any book in your library at any time.',
                'category_id' => $category->id,
                'sort_order' => 4,
                'is_published' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'How do I search for books?'],
            [
                'answer' => 'You can search for books using the search bar on the Books page. You can search by title, author, genre, or ISBN. You can also filter books by genre using the dropdown filter.',
                'category_id' => $category->id,
                'sort_order' => 5,
                'is_published' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question' => 'Can I suggest new features?'],
            [
                'answer' => 'Absolutely! We love hearing from our community. You can contact us through the Contact page with your suggestions, feedback, or any questions you might have.',
                'category_id' => $category->id,
                'sort_order' => 6,
                'is_published' => true,
            ]
        );
    }
}
