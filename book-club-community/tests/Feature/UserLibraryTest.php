<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLibraryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_authenticated_user_can_view_library(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/library');
        $response->assertStatus(200);
        $response->assertSee('My Library');
    }

    public function test_guest_cannot_access_library(): void
    {
        $response = $this->get('/library');
        $response->assertRedirect('/login');
    }

    public function test_user_can_add_book_to_library(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post('/library', [
            'book_id' => $book->id,
            'status' => 'want_to_read'
        ]);

        $this->assertDatabaseHas('book_user', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'want_to_read'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_user_cannot_add_same_book_twice(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Add book first time
        $user->books()->attach($book->id, ['status' => 'want_to_read']);

        // Try to add same book again
        $response = $this->actingAs($user)->post('/library', [
            'book_id' => $book->id,
            'status' => 'currently_reading'
        ]);

        $response->assertSessionHas('error');
    }

    public function test_user_can_update_book_status_in_library(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Add book to library
        $user->books()->attach($book->id, ['status' => 'want_to_read']);

        $response = $this->actingAs($user)->patch("/library/{$book->id}", [
            'status' => 'currently_reading'
        ]);

        $this->assertDatabaseHas('book_user', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'currently_reading'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_user_can_remove_book_from_library(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Add book to library
        $user->books()->attach($book->id, ['status' => 'read']);

        $response = $this->actingAs($user)->delete("/library/{$book->id}");

        $this->assertDatabaseMissing('book_user', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_library_requires_valid_status(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post('/library', [
            'book_id' => $book->id,
            'status' => 'invalid_status'
        ]);

        $response->assertSessionHasErrors(['status']);
    }

    public function test_library_requires_existing_book(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/library', [
            'book_id' => 99999,
            'status' => 'want_to_read'
        ]);

        $response->assertSessionHasErrors(['book_id']);
    }

    public function test_library_can_be_searched(): void
    {
        $user = User::factory()->create();
        $book1 = Book::factory()->create(['title' => 'Harry Potter']);
        $book2 = Book::factory()->create(['title' => 'Lord of the Rings']);

        $user->books()->attach($book1->id, ['status' => 'read']);
        $user->books()->attach($book2->id, ['status' => 'want_to_read']);

        $response = $this->actingAs($user)->get('/library?search=Harry');

        $response->assertStatus(200);
        $response->assertSee('Harry Potter');
    }

    public function test_library_can_be_filtered_by_status(): void
    {
        $user = User::factory()->create();
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        $user->books()->attach($book1->id, ['status' => 'read']);
        $user->books()->attach($book2->id, ['status' => 'want_to_read']);

        $response = $this->actingAs($user)->get('/library?status=read');

        $response->assertStatus(200);
    }

    public function test_library_shows_correct_statistics(): void
    {
        $user = User::factory()->create();
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();
        $book3 = Book::factory()->create();

        $user->books()->attach($book1->id, ['status' => 'read']);
        $user->books()->attach($book2->id, ['status' => 'currently_reading']);
        $user->books()->attach($book3->id, ['status' => 'want_to_read']);

        $response = $this->actingAs($user)->get('/library');

        $response->assertStatus(200);
        $response->assertSee('3'); // Total books
        $response->assertSee('1'); // Want to read, Currently reading, Read counts
    }
}
