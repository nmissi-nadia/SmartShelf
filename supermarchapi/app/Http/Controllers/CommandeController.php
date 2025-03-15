<?php

namespace App\Http\Controllers;
use App\Jobs\UpdateStockJob;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Produit;
use App\Http\Controllers\ProduitSeuilAlerte;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::all();
        return response()->json($commandes);
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'prix_total' => 'required',
            'produit_id' => 'required',
        ]);
        $commande = Commande::create($request->all());
        // Récupérer le produit
        $produit = Produit::findOrFail($request->produit_id);
        // Mettre à jour la quantité
        $nouvelleQuantite = $produit->quantite - 1;
        $produit->update(['quantite' => $nouvelleQuantite]);

        // Vérifier si le produit passe sous le seuil d'alerte
        $seuilAlerte = 5; // Seuil fixe ou récupéré depuis une configuration
        if ($nouvelleQuantite <= $seuilAlerte) {
            event(new ProduitSeuilAlerte($produit));
        }
        // Dispatcher le Job pour mettre à jour le stock
        UpdateStockJob::dispatch($produit, 1);
        return response()->json($commande, 201);
    }
    public function show($id)
    {
        $commande = Commande::findOrFail($id);
        return response()->json($commande);
    }
    public function update(Request $request, Commande $commande)
    {
        $commande->update($request->all());
        return response()->json($commande);
    }
    public function destroy(Commande $commande)
    {
        $commande->delete();
        return response()->json($commande);
    }
}
