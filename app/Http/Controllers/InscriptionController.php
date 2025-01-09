<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Vonage\Client\Credentials\Basic;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InscriptionController extends Controller
{
    public function index()
    {
        return view('inscription');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nomclient' => 'required|string|max:255',
            'prenomclient' => 'required|string|max:255',
            'mailclient' => 'required|email|unique:client', 
            'datenaissance' => 'required|date|before:'.Carbon::now()->subYears(18)->toDateString(), // Validation de l'âge minimum de 18 ans',
            'telclient' => ['required', 'regex:/^0[123456789]\d{8}$/'], 'unique:client', 
            'mot_de_passe_client' => 'required|confirmed|min:8',
        ], [
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

        // Génération des codes de vérification
        $emailVerificationCode = rand(100000, 999999);
        $smsVerificationCode = rand(100000, 999999);

        // Stocker les données et codes temporairement dans le cache
        Cache::put("user_registration_{$request->mailclient}", [
            'nomclient' => $request->nomclient,
            'prenomclient' => $request->prenomclient,
            'mailclient' => $request->mailclient,
            'email_code' => $emailVerificationCode,
            'sms_code' => $smsVerificationCode, // Nouveau code pour SMS
            'datenaissance' => $request->datenaissance,
            'telclient' => $request->telclient,
            'mot_de_passe_client' => $request->mot_de_passe_client,
        ], now()->addMinutes(15));

        // Stocker l'email pour la session
        session(['user_email' => $request->mailclient]);

        // Envoi de l'e-mail avec EmailJS
        $response = Http::post('https://api.emailjs.com/api/v1.0/email/send', [
            'service_id' => env('EMAILJS_SERVICE_ID'), 
            'template_id' => env('EMAILJS_TEMPLATE_ID'), 
            'user_id' => env('EMAILJS_USER_ID'), 
            'template_params' => [
                'mailclient' => $request->mailclient,
                'subject' => 'Code de vérification',
                'message' => 'Votre code de vérification est: ' . $emailVerificationCode,
                'prenomclient' => $request->prenomclient, 
            ],
        ]);

        if ($response->failed()) {
            return back()->withErrors('Une erreur s\'est produite lors de l\'envoi de l\'email.');
        }

        // Envoi du code de vérification par SMS avec Vonage
        $this->sendSms($request->telclient, $smsVerificationCode);

        return redirect()->route('verification.notice');
    }
    
    private function sendSms($recipientNumber, $code)
    {
        // Configuration de Vonage
        $basic  = new \Vonage\Client\Credentials\Basic("7213c435", "GNdApCKvsu67y8op");
        $client = new \Vonage\Client($basic);
    
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("33".$recipientNumber, 'VINOTRIP', 'Votre code de vérification est : '.$code)
        );
    
        $message = $response->current();
    
        if ($message->getStatus() == 0) {
            // Le message a été envoyé avec succès
            //dd($code);
            return true;
        } else {
            // Échec de l'envoi du message
            throw new \Exception("L'envoi du SMS a échoué avec le statut : " . $message->getStatus());
        }
    }    
}