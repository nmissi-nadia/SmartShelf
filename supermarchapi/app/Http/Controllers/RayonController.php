<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rayon;


class RayonController extends Controller
{
    public function index()
      {

          return Rayon::all();
      }
  
      public function store(Request $request)
      {
          $request->validate(['nom' => 'required|string']);
          Rayon::create($request->all());
          return response()->json(['message' => 'Rayon ajouté avec succès'], 201);
      }
      public function show($id)
      {
          $rayon = Rayon::findOrFail($id)->with('categories')->with('produits')->get();
          return response()->json($rayon);
      }
  
      public function update(Request $request, Rayon $rayon)
      {
          $rayon->update($request->all());
          return response()->json(['message' => 'Rayon mis à jour avec succès'], 200);
      }
  
      public function destroy(Rayon $rayon)
      {
          $rayon->delete();
          return response()->json(['message' => 'Rayon supprimé'], 200);
      }
}
