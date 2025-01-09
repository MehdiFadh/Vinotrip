<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Importer la façade Hash pour la comparaison sécurisée
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;  // Assurez-vous d'importer votre modèle utilisateur si nécessaire

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Affiche le formulaire de connexion
    }

    // Gère la soumission du formulaire de connexion
    public function login(Request $request)
    { 
        // Validation des données du formulaire
        $validated = $request->validate([
            'mailclient' => 'required|email',  // 'mailclient' est l'input du formulaire
            'mot_de_passe_client' => 'required|min:8',
        ]);

        // Log de validation
        Log::info('Tentative de connexion', ['email' => $request->mailclient]);

        // Recherche l'utilisateur par l'email
        $user = User::where('mailclient', $request->mailclient)->first();

        // Vérifie si l'utilisateur existe et si le mot de passe est correct
        if ($user && Hash::check($request->mot_de_passe_client, $user->mot_de_passe_client)) {
            // Connexion réussie
            Auth::login($user);  // Connecte l'utilisateur
            Log::info('Connexion réussie pour l\'utilisateur', ['email' => $request->mailclient]);
            return redirect()->intended('/'); // Redirige vers la page d'accueil
        }

        // Si la connexion échoue, log l'erreur
        Log::warning('Échec de la connexion', ['email' => $request->mailclient]);

        // Si la connexion échoue
        throw ValidationException::withMessages([
            'mailclient' => ['Les informations de connexion sont incorrectes.'],
        ]);
    }

    // Déconnecter l'utilisateur
    public function logout()
    {
        Log::info('Déconnexion de l\'utilisateur', ['user' => Auth::user()]);

        Auth::logout(); // Déconnecter l'utilisateur
        Log::info('Utilisateur déconnecté');

        return redirect('/'); // Rediriger vers la page d'accueil après la déconnexion
    }
}
