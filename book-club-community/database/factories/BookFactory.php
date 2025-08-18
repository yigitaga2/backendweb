<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->isbn13(),
            'description' => $this->faker->paragraph(3),
            'publication_year' => $this->faker->numberBetween(1900, 2024),
            'pages' => $this->faker->numberBetween(100, 1000),
            'genre' => $this->faker->randomElement([
                'Fiction', 'Non-Fiction', 'Mystery', 'Romance', 'Science Fiction',
                'Fantasy', 'Biography', 'History', 'Self-Help', 'Thriller'
            ]),
            'cover_image' => null,
        ];
    }
}
