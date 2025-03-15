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
        $produitData = Produit::factory()->make(); 

       
        $data = [
            'nom' => $produitData->nom,
            'prix' => $produitData->prix,
            'quantite' => $produitData->quantite,
            'pourcentage_sold' => $produitData->pourcentage_sold,
            'en_promotion' => $produitData->en_promotion,
            'categorie_id' => $produitData->categorie_id,
        ];
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/produits', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Produit ajouté avec succès']);
    }
    
    /** @test */
    public function un_admin_peut_recuperer_un_produit()
    {
        // Créer un administrateur
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('auth_token')->plainTextToken;

        $produit = Produit::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/produits/{$produit->id}");

        // Assertions
        $response->assertStatus(200) 
                 ->assertJsonFragment([$produit]);
    }
    

    /** @test */
    public function un_admin_peut_supprimer_un_produit()
    {
        // Créer un administrateur
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('auth_token')->plainTextToken;

        // Créer un produit
        $produit = Produit::factory()->create();

        // Requête DELETE pour supprimer un produit
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/produits/{$produit->id}");

        // Assertions
        $response->assertStatus(204); 
        $this->assertDatabaseMissing('produits', ['id' => $produit->id]); // Vérifie que le produit a été supprimé
    }
}
