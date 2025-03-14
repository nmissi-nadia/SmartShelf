<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Admin
    Route::apiResource('rayons', RayonController::class);
    Route::post('/rayons', [RayonController::class, 'store']);
    Route::get('/rayons/{id}', [RayonController::class, 'show']);
    Route::put('/rayons/{id}', [RayonController::class, 'update']);
    Route::delete('/rayons/{id}', [RayonController::class, 'destroy']);
    Route::apiResource('categories', CategorieController::class);
    Route::post('/categories', [CategorieController::class, 'store']);
    Route::get('/categories/{id}', [CategorieController::class, 'show']);
    Route::put('/categories/{id}', [CategorieController::class, 'update']);
    Route::delete('/categories/{id}', [CategorieController::class, 'destroy']);

    
    Route::apiResource('produits', ProduitController::class);
    Route::post('/produits', [ProduitController::class, 'store']);
    Route::get('/produits', [ProduitController::class, 'index']);
    Route::get('/produits/{id}', [ProduitController::class, 'show']);
    Route::put('/produits/{id}', [ProduitController::class, 'update']);
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);

    // Route::post('/produits', [ProduitController::class, 'store']);
    Route::get('/statistiques/produits-les-plus-vendus', [ProduitController::class, 'produitsLesPlusVendus']);
    Route::apiResource('commandes', CommandeController::class);
    // Client
    // Route::get('/produits', [ProduitController::class, 'index']); // Liste des produits
    Route::get('/produits/recherche', [ProduitController::class, 'search']); // Rechercher un produit
    Route::get('/produits/populaires', [ProduitController::class, 'produitsPopulaires']); // Produits populaires
    Route::get('/produits/promotion', [ProduitController::class, 'produitsEnPromotion']);
    // gestion des commandes
    Route::post('/commandes', [CommandeController::class, 'store']);
    // afficher les commandes que le client fait
    
});
