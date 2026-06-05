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
        $email = session('user_email'); 
        Log::info('Verification: Affichage du formulaire de vérification', ['email' => $email]);
        if (!$email) 
        {
            Log::warning('Verification: Email non trouvé dans la session');
            return redirect()->route('inscription.index')->with('error', 'Email non trouvé dans la session.');
        }
        return view('auth.verification', ['email' => $email]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email_code' => 'required|numeric',
            /*'sms_code' => 'required|numeric',*/
            'email' => 'required|email',
        ]);
        $cachedData = Cache::get("user_registration_{$request->email}");
        if (!$cachedData) 
        {
            return redirect()->route('inscription.index')->with('error', 'Les informations de vérification ont expiré.');
        }
        if ($cachedData['email_code'] != $request->email_code) 
        {

            return redirect()->back()->withInput()->with('error', 'Le code de vérification e-mail est incorrect.');
        }
        /*if ($cachedData['sms_code'] != $request->sms_code) {
            return redirect()->back()->withInput()->with('error', 'Le code de vérification SMS est incorrect.');
        }*/
    
        try {
            if (User::where('mailclient', $cachedData['mailclient'])->exists()) 
            {
                return redirect()->back()->withInput()->with('error', 'L\'email est déjà utilisé.');
            }
            if (User::where('telclient', $cachedData['telclient'])->exists()) 
            {
                return redirect()->back()->withInput()->with('error', 'Le numéro de téléphone est déjà utilisé.');
            }
            $user = User::create([
                'nomclient' => $cachedData['nomclient'],
                'prenomclient' => $cachedData['prenomclient'],
                'mailclient' => $cachedData['mailclient'],
                'datenaissance' => $cachedData['datenaissance'],
                'telclient' => $cachedData['telclient'],
                'mot_de_passe_client' => bcrypt($cachedData['mot_de_passe_client']),
            ]);
            if (!$user) 
            {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du compte.');
            }
            Cache::forget("user_registration_{$request->email}");
        } 
        catch (\Exception $e) 
        {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la création de votre compte.');
        }
        return redirect('/')->with('success', 'Votre compte a été vérifié avec succès.');
    }    
}
