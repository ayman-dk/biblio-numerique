<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'cover_image', 'pdf_path', 'published_at', 'author_id', 'category_id'];

    // Un livre appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Un livre appartient à un auteur
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // Un livre possède plusieurs commentaires
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Les utilisateurs qui ont liké ce livre
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'book_user_likes')->withTimestamps();
    }

    // Les utilisateurs qui ont sauvegardé ce livre
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'book_user_saved')->withTimestamps();
    }
}
