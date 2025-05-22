<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function connexion(Request $request)
    {
        $email = request()->query('email');
        $password = request()->query('password');
        $user = User::where('email', $email)->first();
    
        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);

                if (is_null($user->roles)) {
                    $this->setRoleUser($user);
                }

                return response()->json(
                    [
                        'message' => 'Authentification réussie.',
                        'role' => $user->roles,
                    ],
                    200);
            } else {
                return response()->json(['message' => 'Le mot de passe que vous avez saisi est incorrect.'], 401);
            }
        } else {
            return response()->json(['message' => 'Aucun compte n\'est lié à cette adresse électronique.'], 404);
        }
    }

    public function setRoleUser($user) {
        $user->roles = ['ROLE_USER'];
        $user->save();
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
            'name' => $email,
            'password_length' => strlen($password),
        ]);
        
        $this->setRoleUser($newUser);

        Auth::login($newUser);

        return response()->json(
            [
                'message' => 'Inscription réussie.',
                'role' => $newUser->roles,
        ],
            201);
    }

    public function getLengthPassword() {
        $email = request()->input('email');
        $user = User::where('email', $email)->first();

        if ($user && $user->password_length) {
            return response()->json(['password_length' => $user->password_length]);
        }
    
        return response()->json(['message' => 'Utilisateur non trouvé ou mot de passe manquant'], 404);
    }

    public function comparePassword(Request $request)
    {
        $user = Auth::user();  // Récupère l'utilisateur connecté
    
        if ($user && !Hash::check($request->newPassword, $user->password)) {
            $user->password = Hash::make($request->newPassword);  // Hash le nouveau mot de passe
            $user->save();
    
            return response()->json(['message' => 'Mot de passe mis à jour avec succès !']);
        }
    
        return response()->json(['message' => 'Les mots de passe sont identiques. Aucune mise à jour effectuée.']);
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->password = Hash::make($request->newPassword);
        $user->password_length = strlen($request->newPassword);
        $user->save();

        return response()->json(['message' => 'Mot de passe mis à jour avec succès.']);
    }


}
