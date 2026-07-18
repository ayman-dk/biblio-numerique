<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Lister tous les utilisateurs (Admin)
    public function index()
    {
        return response()->json(User::all());
    }

    // Afficher un utilisateur spécifique avec ses interactions (Admin)
    public function show(string $id)
    {
        // On récupère l'utilisateur avec ses commentaires et ses livres likés/sauvegardés
        $user = User::with(['comments', 'likedBooks', 'savedBooks'])->findOrFail($id);
        return response()->json($user);
    }

    // Mettre à jour un utilisateur (Admin : ex: changer son rôle)
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|required|in:user,admin', // On s'assure que le rôle est valide
        ]);

        $user->update($validatedData);

        return response()->json($user);
    }

    // Supprimer (bloquer/bannir) un utilisateur (Admin)
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
