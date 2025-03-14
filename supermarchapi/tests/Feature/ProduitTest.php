<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Produit;
use App\Models\Categorie;
use PHPUnit\Framework\Attributes\Test;


class ProduitTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base de données après chaque test

    /** @test */
 
    public function un_admin_peut_creer_un_produit()
            {
                // Créer un administrateur
                $admin = User::factory()->create(['role' => 'admin']);
                $token = $admin->createToken('auth_token')->plainTextToken;

                // Utiliser la factory pour créer un produit avec ses relations (catégorie)
                $produitData = Produit::factory()->make(); // `make()` crée l'objet sans l'enregistrer en base

                // Données du produit
                $data = [
                    'nom' => $produitData->nom,
                    'prix' => $produitData->prix,
                    'quantite' => $produitData->quantite,
                    'pourcentage_sold' => $produitData->pourcentage_sold,
                    'en_promotion' => $produitData->en_promotion,
                    'categorie_id' => $produitData->categorie_id, // Catégorie créée par la factory
                ];
                // Requête POST pour créer un produit
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/produits', $data);

    // Assertions
    $response->assertStatus(201)
             ->assertJsonFragment(['nom' => $produitData->nom]);
    }
}
