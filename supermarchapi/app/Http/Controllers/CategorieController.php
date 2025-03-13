<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Rayon;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return response()->json($categories);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom'=>'required|string|max:50',
            'rayon_id'=>'required|exists:rayons,id'
        ]);
        $categorie=Categorie::create([
            'nom'=>$request->nom,
            'rayon_id'=>$request->rayon_id
        ]);
        return response()->json($categorie,201);
    }
        public function show($id)
        {
            $categorie=Categorie::findOrFail($id);
            return response()->json($categorie);
        }
        public function update(Request $request,$id)
        {
            $categorie=Categorie::findOrFail($id);
            $categorie->update($request->all());
            return response()->json($categorie);
        }
    public function destroy($id)
    {
        $categorie=Categorie::findOrFail($id);
        $categorie->delete();
        return response()->json($categorie);
    }
}
