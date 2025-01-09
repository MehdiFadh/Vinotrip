<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\CommandeSejour;
use App\Models\AdresseClient; 
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    // Liste toutes les commandes (index par défaut)
    public function index()
    {
        return view('commandes', [
            'commandes' => Commande::all()
        ]);
    }

    // Historique des commandes
    public function historique()
    {
        // Identifiant du client connecté
        $idclient = auth()->user()->idclient;
    
        // Récupérer les commandes avec leur facture
        $commandes = DB::table('commande')
            ->leftJoin('facture', 'commande.numcommande', '=', 'facture.numcommande')
            ->where('commande.idclient', $idclient)
            ->orderBy('commande.numcommande', 'desc') 
            ->select(
                'commande.*', // Toutes les colonnes de commande
                'facture.montant_total', // Colonne montant_total de la facture
                'facture.description_facture as facture_pdf', // Fichier PDF (colonne chemin ou description)
                'facture.date_facturation' // Date de la facture, si besoin
            )
            ->get();
    
        // Retourner la vue avec les commandes récupérées
        return view('commandes.historique', compact('commandes'));
    }

    public function details($numcommande)
    {
        $commande = DB::table('commande')
            ->where('numcommande', $numcommande)
            ->first();

        if (!$commande) {
            return redirect()->route('commandes.historique')->with('error', 'Commande introuvable.');
        }

        // Récupérer les détails des effectifs
        $effectifs = DB::table('commande_effectif')
            ->join('commande', 'commande_effectif.numcommande', '=', 'commande.numcommande')
            ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
            ->where('commande_effectif.numcommande', $numcommande)
            ->select('sejour.titresejour as nom', 'commande_sejour.nbr_adulte as nb_adultes','commande_sejour.nbr_chambre as chambres','commande_effectif.date_debut_sejour as date')
            ->get();

        // Récupérer les détails des cadeaux
        $cadeaux = DB::table('commande_cadeau')
            ->join('commande', 'commande_cadeau.numcommande', '=', 'commande.numcommande')
            ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
            ->where('commande_cadeau.numcommande', $numcommande)
            ->select('sejour.titresejour as nom', 'commande_sejour.nbr_adulte as nb_adultes','commande_sejour.nbr_chambre as chambres')
            ->get();

        // Récupérer le montant total de la facture
        $facture = DB::table('facture')
            ->where('numcommande', $numcommande)
            ->select('montant_total')
            ->first();

        return view('commandes.details', compact('commande', 'effectifs', 'cadeaux', 'facture'));
    }

    public function choisirAdresse(Request $request)
    {
        $user = auth()->user();
        $adresses = AdresseClient::where('idclient', $user->idclient)->get();

        return view('commandes.choisir-adresse', compact('adresses'));
    }

    public function enregistrerAdresse(Request $request)
    {
        $request->validate([
            'nom_adresse_client' => 'required|string|max:100',
            'ligne1' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:50',
        ]);
    
        $adresse = new AdresseClient([
            'idclient' => auth()->user()->idclient, // Récupérer l'idClient de l'utilisateur connecté
            'nom_adresse_client' => $request->input('nom_adresse_client'),
            'rue_client' => $request->input('ligne1'),
            'code_postal_client' => $request->input('code_postal'),
            'ville_client' => $request->input('ville'),
            'pays_client' => $request->input('pays'),
        ]);
    
        // Sauvegarder l'adresse
        $adresse->save();
    
        return redirect()->route('commande.adresse')->with('success', 'Nouvelle adresse ajoutée avec succès.');
    }
    

}
