<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_reviews_index_page_can_be_rendered(): void
    {
        $response = $this->get('/reviews');
        $response->assertStatus(200);
        $response->assertSee('Community Reviews');
    }

    public function test_authenticated_user_can_create_review(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $reviewData = [
            'book_id' => $book->id,
            'stars' => 5,
            'review' => 'This is an amazing book!'
        ];

        $response = $this->actingAs($user)->post('/reviews', $reviewData);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'stars' => 5,
            'review' => 'This is an amazing book!'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_guest_cannot_create_review(): void
    {
        $book = Book::factory()->create();

        $reviewData = [
            'book_id' => $book->id,
            'stars' => 5,
            'review' => 'This is an amazing book!'
        ];

        $response = $this->post('/reviews', $reviewData);
        $response->assertRedirect('/login');
    }

    public function test_review_requires_valid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/reviews', []);

        $response->assertSessionHasErrors(['book_id', 'stars']);
    }

    public function test_stars_must_be_between_1_and_5(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Test invalid star rating
        $response = $this->actingAs($user)->post('/reviews', [
            'book_id' => $book->id,
            'stars' => 6,
            'review' => 'Test review'
        ]);

        $response->assertSessionHasErrors(['stars']);
    }

    public function test_user_cannot_review_same_book_twice(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Create first review
        Review::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'stars' => 4
        ]);

        // Try to create second review
        $response = $this->actingAs($user)->post('/reviews', [
            'book_id' => $book->id,
            'stars' => 5,
            'review' => 'Another review'
        ]);

        $response->assertSessionHas('error');
    }

    public function test_user_can_update_their_own_review(): void
    {
        $user = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'book_id' => $review->book_id,
            'stars' => 3,
            'review' => 'Updated review content'
        ];

        $response = $this->actingAs($user)->patch("/reviews/{$review->id}", $updateData);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'stars' => 3,
            'review' => 'Updated review content'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_user_cannot_update_others_review(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->patch("/reviews/{$review->id}", [
            'book_id' => $review->book_id,
            'stars' => 1,
            'review' => 'Hacked review'
        ]);

        $response->assertSessionHas('error');
    }

    public function test_user_can_delete_their_own_review(): void
    {
        $user = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/reviews/{$review->id}");

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_reviews_can_be_searched(): void
    {
        $book1 = Book::factory()->create(['title' => 'Harry Potter']);
        $book2 = Book::factory()->create(['title' => 'Lord of the Rings']);

        Review::factory()->create(['book_id' => $book1->id]);
        Review::factory()->create(['book_id' => $book2->id]);

        $response = $this->get('/reviews?search=Harry');

        $response->assertStatus(200);
        $response->assertSee('Harry Potter');
    }

    public function test_reviews_can_be_filtered_by_stars(): void
    {
        Review::factory()->create(['stars' => 5]);
        Review::factory()->create(['stars' => 3]);

        $response = $this->get('/reviews?stars=5');

        $response->assertStatus(200);
    }
}
