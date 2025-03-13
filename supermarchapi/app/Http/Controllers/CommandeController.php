<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;

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
