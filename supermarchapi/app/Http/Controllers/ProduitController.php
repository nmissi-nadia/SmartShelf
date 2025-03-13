<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
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
          return response()->json(['message' => 'Produit supprimé'], 200);
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
}
