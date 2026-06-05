<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CommandeCadeau;
use App\Models\CommandeEffectif;
use App\Models\AdresseClient;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Mail\SuppressionDonneeMail;
use Illuminate\Support\Facades\Mail;



class AccountController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $commandesCadeaux = CommandeCadeau::where('idclient', $user->idclient)->get();

        $commandesEffectifs = CommandeEffectif::where('idclient', $user->idclient)->get();

        return view('account.show', compact('user', 'commandesCadeaux', 'commandesEffectifs'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nomclient' => 'required|string|max:255',
            'prenomclient' => 'required|string|max:255',
            'mailclient' => 'required|email|max:255',
            'telclient' => ['required', 'regex:/^0[67]\d{8}$/'], 'unique:client',  
            'datenaissance' => 'required|date|before:'.Carbon::now()->subYears(18)->toDateString(), 
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

        $user = Auth::user();

        $user->update([
            'nomclient' => $request->nomclient,
            'prenomclient' => $request->prenomclient,
            'mailclient' => $request->mailclient,
            'datenaissance' => $request->datenaissance,
            'telclient' => $request->telclient,
        ]);

        return redirect()->route('account.show')->with('success', 'Vos informations ont été mises à jour avec succès.');
    }
    /*Méthode d'affichage des données personnelles de l'utilisateur*/
    public function demandeDonneePersonnel($numclient)
    {

        $client = Client::findOrFail($numclient);

        $adresseclient = DB::select('SELECT * from adresse_client where idclient = '.$numclient)[0];

        try {
            $referencebancaire = DB::select('Select * from reference_bancaire where idclient = '.$numclient)[0];
        } catch (\Exception $e) {
            $referencebancaire = null;
        }

        $commande = DB::select('select * from commande where idclient = ' .$numclient);

        return view('account.donneepersonnel', compact('client', 'adresseclient', 'referencebancaire', 'commande'));
    }
    /*Méthode suppression des données personnelles de l'utilisateur*/
    public function suppressionDonneePersonnel($numclient){

        $client = client::findOrFail($numclient);

        Mail::to('vinotrip1@gmail.com')->send(new SuppressionDonneeMail($client));

        session()->flash('success', 'Un e-mail a été envoyé à l\'équipe vinotrip pour supprimer vos données.');
        
        return redirect()->back();
    }

   /*Méthode de mise à jour du mot de passe*/
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

    
        if (!Hash::check($request->current_password, $user->mot_de_passe_client)) {
            
            if (md5($request->current_password) !== $user->mot_de_passe_client) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            
            $user->mot_de_passe_client = Hash::make($request->current_password);
            $user->save();
        }

        
        $user->mot_de_passe_client = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }


}
