<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
   /**
 * @OA\Post(
 *     path="/api/auth/register",
 *     summary="Register a new user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User registered successfully"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
    // Inscription
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8',
            'role'=>'required|in:admin,client|'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token,'message' => 'Inscription avec succès']);
    }
    // Connexion
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required||string|email',
            'password'=>'required|string'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password))
        {
            throw ValidaionException::withMessages([
                'email' => ['Les informations d\'identification sont incorrectes.'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token,'message' => 'Connexion avec succès'], 200);
    }
    // public function logout(Request $request)
    // {
    //     $user = $request->user();
    //     if ($user && $user->currentAccessToken()) {
    //         $user->currentAccessToken()->delete();
    //         return response()->json(['message' => 'Déconnecté avec succès'], 200);
    //     }

    //     return response()->json(['message' => 'Utilisateur non connecté'], 401);
    // }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ], 200);
    }
}
