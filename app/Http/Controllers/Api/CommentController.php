<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        // Retourne les commentaires récents (avec les infos de l'utilisateur et du livre)
        return response()->json(Comment::with(['user', 'book'])->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id', // Plus tard, on récupérera l'ID via Sanctum ($request->user()->id)
        ]);

        $comment = Comment::create($validated);

        return response()->json($comment, 201);
    }

    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        
        // Logique de sécurité à ajouter plus tard : vérifier si l'utilisateur qui supprime est bien le propriétaire du commentaire ou un admin.
        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé']);
    }
}
