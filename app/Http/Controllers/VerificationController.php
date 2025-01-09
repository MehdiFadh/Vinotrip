<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function show()
    {
        // Récupérer l'email de la session pour le formulaire de vérification
        $email = session('user_email'); 

        Log::info('Verification: Affichage du formulaire de vérification', ['email' => $email]);

        if (!$email) {
            Log::warning('Verification: Email non trouvé dans la session');
            return redirect()->route('inscription.index')->with('error', 'Email non trouvé dans la session.');
        }

        // Passer l'email à la vue pour la préremplir dans le formulaire
        return view('auth.verification', ['email' => $email]);
    }

    public function verify(Request $request)
    {
        // Log pour vérifier si la méthode est atteinte
        Log::info('Verification: Méthode verify() appelée', [
            'email' => $request->email,
            'email_code' => $request->email_code,
            'sms_code' => $request->sms_code,
        ]);
    
        // Validation des données d'entrée
        $request->validate([
            'email_code' => 'required|numeric',
            'sms_code' => 'required|numeric',
            'email' => 'required|email',
        ]);
    
        // Log pour vérifier si la validation passe
        Log::info('Verification: Validation passée', [
            'email_code' => $request->email_code,
            'sms_code' => $request->sms_code
        ]);
    
        // Récupérer les données depuis le cache
        $cachedData = Cache::get("user_registration_{$request->email}");
        if (!$cachedData) {
            Log::warning('Verification: Données non trouvées dans le cache', ['email' => $request->email]);
            return redirect()->route('inscription.index')->with('error', 'Les informations de vérification ont expiré.');
        }
    
        // Vérifier les codes de vérification (e-mail et SMS)
        if ($cachedData['email_code'] != $request->email_code) {
            Log::warning('Verification: Code email incorrect', [
                'expected_email_code' => $cachedData['email_code'],
                'received_email_code' => $request->email_code
            ]);
            return redirect()->back()->withInput()->with('error', 'Le code de vérification e-mail est incorrect.');
        }
    
        if ($cachedData['sms_code'] != $request->sms_code) {
            Log::warning('Verification: Code SMS incorrect', [
                'expected_sms_code' => $cachedData['sms_code'],
                'received_sms_code' => $request->sms_code
            ]);
            return redirect()->back()->withInput()->with('error', 'Le code de vérification SMS est incorrect.');
        }
    
        try {
            // Log pour vérifier si la logique continue
            Log::info('Verification: Début de la création de l\'utilisateur', ['cachedData' => $cachedData]);
    
            // Vérification si l'email ou le téléphone existe déjà dans la base de données
            if (User::where('mailclient', $cachedData['mailclient'])->exists()) {
                Log::warning('Verification: L\'email est déjà utilisé', ['email' => $cachedData['mailclient']]);
                return redirect()->back()->withInput()->with('error', 'L\'email est déjà utilisé.');
            }
    
            if (User::where('telclient', $cachedData['telclient'])->exists()) {
                Log::warning('Verification: Le numéro de téléphone est déjà utilisé', ['telclient' => $cachedData['telclient']]);
                return redirect()->back()->withInput()->with('error', 'Le numéro de téléphone est déjà utilisé.');
            }
    
            // Créer l'utilisateur dans la base de données
            $user = User::create([
                'nomclient' => $cachedData['nomclient'],
                'prenomclient' => $cachedData['prenomclient'],
                'mailclient' => $cachedData['mailclient'],
                'datenaissance' => $cachedData['datenaissance'],
                'telclient' => $cachedData['telclient'],
                'mot_de_passe_client' => bcrypt($cachedData['mot_de_passe_client']),
            ]);
    
            // Vérification de la création de l'utilisateur
            if (!$user) {
                Log::error('Verification: Erreur lors de la création de l\'utilisateur', ['cachedData' => $cachedData]);
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du compte.');
            }
    
            // Supprimer les données mises en cache
            Cache::forget("user_registration_{$request->email}");
    
            Log::info('Verification: Utilisateur créé avec succès', ['user' => $user]);
    
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans les logs
            Log::error('Verification: Exception lors de la création de l\'utilisateur', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la création de votre compte.');
        }
    
        // Rediriger vers la page d'accueil avec succès
        Log::info('Verification: Compté vérifié avec succès', ['email' => $request->email]);
        return redirect('/')->with('success', 'Votre compte a été vérifié avec succès.');
    }    
}
