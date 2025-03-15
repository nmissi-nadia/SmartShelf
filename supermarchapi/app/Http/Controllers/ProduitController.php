<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Rayon;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="SmartShelf API",
 *     version="1.0",
 *     description="API documentation for the SmartShelf project",
 *     @OA\Contact(
 *         name="Nmissinadia",
 *         email="nmissinadia@gmail.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Produit",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="prix", type="number", format="float"),
 *     @OA\Property(property="quantite", type="integer"),
 *     @OA\Property(property="pourcentage_sold", type="integer"),
 *     @OA\Property(property="en_promotion", type="boolean"),
 *     @OA\Property(property="categorie_id", type="integer"),
 * )
 */
class ProduitController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/produits",
     *     summary="Créer un nouveau produit",
     *     tags={"Produits"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "prix", "quantite", "categorie_id"},
     *             @OA\Property(property="nom", type="string", example="Produit Test"),
     *             @OA\Property(property="prix", type="number", format="float", example=100.0),
     *             @OA\Property(property="quantite", type="integer", example=50),
     *             @OA\Property(property="pourcentage_sold", type="integer", example=10),
     *             @OA\Property(property="en_promotion", type="boolean", example=true),
     *             @OA\Property(property="categorie_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produit créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produit ajouté avec succès"),
     *             @OA\Property(property="produit", ref="#/components/schemas/Produit")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Les données sont invalides."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'pourcentage_sold' => 'nullable|integer|min:0|max:100',
            'en_promotion' => 'nullable|boolean',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit = Produit::create($validated);

        return response()->json([
            'message' => 'Produit ajouté avec succès',
            'produit' => $produit,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/produits/{id}",
     *     summary="Récupérer un produit par ID",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produit récupéré avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Produit")
     *     ),
     *     @OA\Response(response=404, description="Produit non trouvé")
     * )
     */
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return response()->json($produit, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/produits/{id}",
     *     summary="Mettre à jour un produit",
     *     tags={"Produits"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Produit")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produit mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produit mis à jour avec succès"),
     *             @OA\Property(property="produit", ref="#/components/schemas/Produit")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Produit non trouvé")
     * )
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'nullable|string',
            'prix' => 'nullable|numeric|min:0',
            'quantite' => 'nullable|integer|min:0',
            'pourcentage_sold' => 'nullable|integer|min:0|max:100',
            'en_promotion' => 'nullable|boolean',
            'categorie_id' => 'nullable|exists:categories,id',
        ]);

        $produit->update($validated);

        return response()->json([
            'message' => 'Produit mis à jour avec succès',
            'produit' => $produit,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/produits/{id}",
     *     summary="Supprimer un produit",
     *     tags={"Produits"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produit supprimé avec succès"
     *     ),
     *     @OA\Response(response=404, description="Produit non trouvé")
     * )
     */
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();

        return response()->noContent();
    }

    /**
     * @OA\Get(
     *     path="/api/produits",
     *     summary="Liste des produits",
     *     tags={"Produits"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des produits récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Produit")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $produits = Produit::with('categorie')->get();
        return response()->json($produits, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/produits/recherche",
     *     summary="Rechercher des produits",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="nom",
     *         in="query",
     *         required=false,
     *         description="Nom du produit",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="categorie_id",
     *         in="query",
     *         required=false,
     *         description="ID de la catégorie",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des produits correspondant aux critères",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Produit")
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = Produit::query();

        if ($request->has('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        if ($request->has('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        $produits = $query->get();
        return response()->json($produits, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/produits/{id}/update-stock",
     *     summary="Mettre à jour le stock d'un produit",
     *     tags={"Produits"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"quantite_vendue"},
     *             @OA\Property(property="quantite_vendue", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Stock mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Stock mis à jour")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Les données sont invalides."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function updateStock(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $request->validate([
            'quantite_vendue' => 'required|integer|min:1',
        ]);

        $nouvelleQuantite = $produit->quantite - $request->quantite_vendue;

        if ($nouvelleQuantite < 0) {
            return response()->json(['message' => 'La quantité vendue dépasse le stock disponible'], 422);
        }

        $produit->update(['quantite' => $nouvelleQuantite]);

        if ($nouvelleQuantite <= 5) {
            // Envoyer une notification (par exemple, via mail)
            // Mail::to('admin@example.com')->send(new NotificationMail($produit));
        }

        return response()->json(['message' => 'Stock mis à jour'], 200);
    }
}