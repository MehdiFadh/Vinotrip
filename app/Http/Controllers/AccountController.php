<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Assurez-vous que votre modèle User est importé
use App\Models\CommandeCadeau;
use App\Models\CommandeEffectif;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function show()
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();
        
        if (!$user) {
            // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer les commandes cadeaux
        $commandesCadeaux = CommandeCadeau::where('idclient', $user->idclient)->get();

        // Récupérer les commandes effectives
        $commandesEffectifs = CommandeEffectif::where('idclient', $user->idclient)->get();

        // Retourner la vue avec les données
        return view('account.show', compact('user', 'commandesCadeaux', 'commandesEffectifs'));
    }
    
    // Met à jour les informations de l'utilisateur
    public function update(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'nomclient' => 'required|string|max:255',
            'prenomclient' => 'required|string|max:255',
            'mailclient' => 'required|email|max:255',
            'telclient' => ['required', 'regex:/^0[67]\d{8}$/'], 'unique:client',  // Validation du numéro de téléphone
            'datenaissance' => 'required|date|before:'.Carbon::now()->subYears(18)->toDateString(), // Validation de l'âge minimum de 18 ans
        ],[
            'nomclient.required' => 'Le champ nom est obligatoire.',
            'prenomclient.required' => 'Le champ prénom est obligatoire.',
            'mailclient.required' => 'Le champ e-mail est obligatoire.',
            'mailclient.email' => 'Veuillez fournir une adresse e-mail valide.',
            'mailclient.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'datenaissance.required' => 'Le champ date de naissance est obligatoire.',
            'datenaissance.before' => 'Vous devez avoir au moins 18 ans.',
            'telclient.required' => 'Le champ téléphone est obligatoire.',
            'telclient.regex' => 'Le format du numéro de téléphone est invalide.',
            'telclient.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'mot_de_passe_client.required' => 'Le champ mot de passe est obligatoire.',
            'mot_de_passe_client.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'mot_de_passe_client.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Mise à jour des informations
        $user->update([
            'nomclient' => $request->nomclient,
            'prenomclient' => $request->prenomclient,
            'mailclient' => $request->mailclient,
            'datenaissance' => $request->datenaissance,
            'telclient' => $request->telclient,
        ]);

        // Retour à la page "Mon Compte" avec un message de succès
        return redirect()->route('account.show')->with('success', 'Vos informations ont été mises à jour avec succès.');
    }
}
