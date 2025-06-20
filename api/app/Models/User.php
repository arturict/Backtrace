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
        'FullName',
        'FirstName',
        'LastName',
        'username',
        'password',
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
        ];
    }

    /**
     * Get the user's email attribute (using username for authentication).
     */
    public function getEmailAttribute()
    {
        return $this->username;
    }

    /**
     * Get the user's name attribute.
     */
    public function getNameAttribute()
    {
        return $this->FullName ?: trim(($this->FirstName ?? '') . ' ' . ($this->LastName ?? ''));
    }

    /**
     * Get the posts authored by this user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the comments authored by this user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
