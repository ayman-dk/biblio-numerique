<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // 1. Lister tous les livres (Public)
    public function index()
    {
        // On charge les relations pour éviter les requêtes N+1
        $books = Book::with(['author', 'category'])->get();
        return response()->json($books);
    }

    // 2. Créer un livre (Admin)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'pdf_path' => 'required|string',
            'published_at' => 'nullable|date',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create($validatedData);

        return response()->json($book, 201);
    }

    // 3. Afficher les détails d'un livre (Public)
    public function show(string $id)
    {
        $book = Book::with(['author', 'category', 'comments.user'])->findOrFail($id);
        return response()->json($book);
    }

    // 4. Mettre à jour un livre (Admin)
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'summary' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'pdf_path' => 'sometimes|required|string',
            'published_at' => 'nullable|date',
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $book->update($validatedData);

        return response()->json($book);
    }

    // 5. Supprimer un livre (Admin)
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Livre supprimé avec succès']);
    }
}
