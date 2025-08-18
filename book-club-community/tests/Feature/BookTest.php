<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_books_index_page_can_be_rendered(): void
    {
        $response = $this->get('/books');
        $response->assertStatus(200);
        $response->assertSee('Book Collection');
    }

    public function test_authenticated_user_can_view_book_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/books/create');
        $response->assertStatus(200);
        $response->assertSee('Add New Book');
    }

    public function test_guest_cannot_access_book_create_page(): void
    {
        $response = $this->get('/books/create');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_book(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $bookData = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'isbn' => '978-0123456789',
            'description' => 'A great test book',
            'publication_year' => 2023,
            'pages' => 300,
            'genre' => 'Fiction',
            'cover_image' => UploadedFile::fake()->image('cover.jpg')
        ];

        $response = $this->actingAs($user)->post('/books', $bookData);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'isbn' => '978-0123456789'
        ]);

        $book = Book::where('title', 'Test Book')->first();
        $response->assertRedirect("/books/{$book->id}");
    }

    public function test_book_creation_requires_title_and_author(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/books', []);

        $response->assertSessionHasErrors(['title', 'author']);
    }

    public function test_book_show_page_displays_book_details(): void
    {
        $book = Book::factory()->create([
            'title' => 'Amazing Book',
            'author' => 'Great Author'
        ]);

        $response = $this->get("/books/{$book->id}");

        $response->assertStatus(200);
        $response->assertSee('Amazing Book');
        $response->assertSee('Great Author');
    }

    public function test_books_can_be_searched(): void
    {
        Book::factory()->create(['title' => 'Harry Potter', 'author' => 'J.K. Rowling']);
        Book::factory()->create(['title' => 'Lord of the Rings', 'author' => 'J.R.R. Tolkien']);

        $response = $this->get('/books?search=Harry');

        $response->assertStatus(200);
        $response->assertSee('Harry Potter');
        $response->assertDontSee('Lord of the Rings');
    }

    public function test_books_can_be_filtered_by_genre(): void
    {
        Book::factory()->create(['title' => 'Fantasy Book', 'genre' => 'Fantasy']);
        Book::factory()->create(['title' => 'Mystery Book', 'genre' => 'Mystery']);

        $response = $this->get('/books?genre=Fantasy');

        $response->assertStatus(200);
        $response->assertSee('Fantasy Book');
        $response->assertDontSee('Mystery Book');
    }
}
