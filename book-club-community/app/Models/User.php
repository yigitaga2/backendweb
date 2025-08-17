<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'birthday',
        'profile_photo',
        'about_me',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
            'is_admin' => 'boolean',
        ];
    }

    // Relationships
    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)
                    ->withPivot('status', 'started_reading_at', 'finished_reading_at')
                    ->withTimestamps();
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo)
            : asset('images/default-avatar.svg');
    }
}
