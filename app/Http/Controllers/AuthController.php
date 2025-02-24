<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function connexion()
    {
        $email = request()->query('email');
        $password = request()->query('password');
        $user = User::where('email', $email)->first();
    
        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                return response()->json(['message' => 'Authentification réussie.'], 200);
            } else {
                return response()->json(['message' => 'Mot de passe incorrect.'], 401);
            }
        } else {
            return response()->json(['message' => 'Aucun utilisateur trouvé avec cette adresse e-mail.'], 404);
        }
    }

    public function inscription()
    {
        $email = request()->input('email');
        $password = request()->input('password');

        $user = User::where('email', $email)->first();
        
        if ($user) {
            return response()->json(['message' => 'Un utilisateur existe déjà avec cette adresse e-mail.'], 409);
        }

        $newUser = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $email
        ]);

        Auth::login($newUser);

        return response()->json(['message' => 'Inscription réussie.'], 201);
    }

    

}
