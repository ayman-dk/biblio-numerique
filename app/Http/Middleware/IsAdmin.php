<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // On vérifie si l'utilisateur est connecté ET si son rôle est "admin"
      if (auth()->check() && auth()->user()->role === 'admin') {
         return $next($request); // C'est bon, on le laisse passer
      }

    // Sinon, on bloque l'accès avec une erreur 403 (Interdit)
      return response()->json(['message' => 'Accès non autorisé. Réservé aux administrateurs.'], 403);
    }
}
