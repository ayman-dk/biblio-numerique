<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json(Author::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string',
        ]);

        $author = Author::create($validated);

        return response()->json($author, 201);
    }

    public function show(string $id)
    {
        // On récupère l'auteur et on inclut directement la liste de ses livres
        $author = Author::with('books')->findOrFail($id);
        return response()->json($author);
    }

    public function update(Request $request, string $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string',
        ]);

        $author->update($validated);

        return response()->json($author);
    }

    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return response()->json(['message' => 'Auteur supprimé avec succès']);
    }
}
