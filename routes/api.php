<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes publiques d'authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes publiques (Consultation du catalogue)
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::apiResource('comments', CommentController::class)->only(['index']);

// Routes protégées par l'authentification Sanctum (pour l'Admin ou les actions utilisateurs)
Route::middleware('auth:sanctum')->group(function () {

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // 1. Accessible à TOUS les utilisateurs connectés (User + Admin)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('comments', CommentController::class)->only(['store', 'destroy']);

    // 2. Le Sous-groupe ultra-sécurisé (Uniquement pour l'Admin)
    Route::middleware('admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        Route::apiResource('authors', AuthorController::class)->except(['index', 'show']);
        Route::apiResource('books', BookController::class)->except(['index', 'show']);
        Route::apiResource('users', UserController::class)->except(['store']);
    });
});

