<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'cover_image',
        'publication_date',
        'pages',
        'publisher',
    ];

    protected function casts(): array
    {
        return [
            'publication_date' => 'date',
            'average_rating' => 'decimal:2',
            'total_reviews' => 'integer',
            'pages' => 'integer',
        ];
    }

    // Relationships
    public function genres()
    {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('status', 'started_reading_at', 'finished_reading_at')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper methods
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-book-cover.svg');
    }

    public function updateRating()
    {
        $reviews = $this->reviews()->where('is_approved', true);
        $this->average_rating = $reviews->avg('rating') ?? 0;
        $this->total_reviews = $reviews->count();
        $this->save();
    }
}
