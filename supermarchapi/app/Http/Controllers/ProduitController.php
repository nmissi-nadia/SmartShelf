<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\User;
use App\Models\Categorie;


class ProduitController extends Controller
{
    public function index()
      {
          return Produit::with('categorie')->get();
      }
      public function search(Request $request)
        {
            $query = Produit::query();
            if ($request->has('nom')) {
                $query->where('nom', 'like', '%' . $request->nom . '%');
            }
            if ($request->has('categorie_id')) {
                $query->where('categorie_id', $request->categorie_id);
            }
            return $query->get();
        }

    
        public function stocksCritiques()
        {
            $produits = Produit::where('quantite', '<=', 5)->get();
            return response()->json($produits, 200);
        }
        public function updateStock(Request $request, Produit $produit)
            {
                $request->validate([
                    'quantite_vendue' => 'required|integer|min:1', // Quantité vendue
                ]);

                // Mettre à jour la quantité
                $nouvelleQuantite = $produit->quantite - $request->quantite_vendue;
                $produit->update(['quantite' => $nouvelleQuantite]);

                // Vérifier si le produit passe sous le seuil d'alerte
                $seuilAlerte = 5; // Seuil fixe
                if ($nouvelleQuantite <= $seuilAlerte) {
                    event(new ProduitSeuilAlerte($produit)); // Déclencher l'événement
                }

                return response()->json(['message' => 'Stock mis à jour'], 200);
            }
      public function store(Request $request)
      {
          $request->validate([
              'nom' => 'required|string',
              'prix' => 'required|numeric',
              'quantite' => 'required|integer',
              'categorie_id' => 'required|exists:categories,id',
          ]);
  
          Produit::create($request->all());
          return response()->json(['message' => 'Produit ajouté avec succès'], 201);
      }
  
      public function update(Request $request, Produit $produit)
      {
          $produit->update($request->all());
          return response()->json(['message' => 'Produit mis à jour avec succès'], 200);
      }
     
  
      public function destroy(Produit $produit)
      {
          $produit->delete();
          return response()->json(['message' => 'Produit supprimé'],204);
      }
      
      public function show($id)
      {
          $produit = Produit::findOrFail($id)->get();
          return response()->json($produit,200);
      }

    //   stats
    public function produitsLesPlusVendus(Request $request)
    {
        $limit = $request->get('limit', 5); 
        $produits = Produit::orderBy('ventes', 'desc')
            ->take($limit)
            ->get(['nom', 'ventes', 'quantite', 'prix']);
        return response()->json($produits, 200);
    }
    public function produitsPopulaires(Request $request)
    {
        $limit = $request->get('limit', 5); 
        $produits = Produit::orderBy('ventes', 'desc')
            ->take($limit)
            ->get(['nom', 'ventes', 'quantite', 'prix']);

        return response()->json($produits, 200);
    }

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
     *             @OA\Property(property="categorie_id", type="integer", example=1)
     *         )
     *     ),
     *  *     @OA\Response(
     *         response=201,
     *         description="Produit créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produit ajouté avec succès"),
     *             @OA\Property(property="produit", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nom", type="string", example="Produit Test"),
     *                 @OA\Property(property="prix", type="number", format="float", example=100.0),
     *                 @OA\Property(property="quantite", type="integer", example=50),
     *                 @OA\Property(property="categorie_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     * *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Les données sont invalides."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
}
