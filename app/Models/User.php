<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    // Les commentaires postés par l'utilisateur
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Les livres que l'utilisateur a likés
    public function likedBooks()
    {
        return $this->belongsToMany(Book::class, 'book_user_likes')->withTimestamps();
    }

    // Les livres sauvegardés par l'utilisateur (Favoris)
    public function savedBooks()
    {
        return $this->belongsToMany(Book::class, 'book_user_saved')->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
