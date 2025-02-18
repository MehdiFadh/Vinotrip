<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sejour;
use App\Models\Commande;
use App\Models\CommandeSejour;
use App\Models\AdresseClient; 
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class CommandeController extends Controller
{
    public function index()
    {
        return view('commandes', [
            'commandes' => Commande::all()
        ]);
    }
    /*Méthode d'affichage de l'historique des commandes de l'utilisateur*/
    public function historique()
    {
        $idclient = auth()->user()->idclient;
    
        $commandes = DB::table('commande')
            ->leftJoin('facture', 'commande.numcommande', '=', 'facture.numcommande')
            ->where('commande.idclient', $idclient)
            ->orderBy('commande.numcommande', 'desc') 
            ->select(
                'commande.*', 
                'facture.montant_total', 
                'facture.description_facture', 
                'facture.date_facturation', 
                'facture.num_facture') 
            ->get();
    
        return view('commandes.historique', compact('commandes'));
    }
    /*Afichage du détail de la commande*/
    public function details($numcommande)
    {
        $commande = DB::table('commande')
            ->where('numcommande', $numcommande)
            ->first();

        if (!$commande) {
            return redirect()->route('commandes.historique')->with('error', 'Commande introuvable.');
        }

        $effectifs = DB::table('commande_effectif')
            ->join('commande', 'commande_effectif.numcommande', '=', 'commande.numcommande')
            ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
            ->where('commande_effectif.numcommande', $numcommande)
            ->select('sejour.titresejour as nom', 'commande_sejour.nbr_adulte as nb_adultes','commande_sejour.nbr_chambre as chambres','commande_effectif.date_debut_sejour as date')
            ->get();

        $cadeaux = DB::table('commande_cadeau')
            ->join('commande', 'commande_cadeau.numcommande', '=', 'commande.numcommande')
            ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
            ->where('commande_cadeau.numcommande', $numcommande)
            ->select('sejour.titresejour as nom', 'commande_sejour.nbr_adulte as nb_adultes','commande_sejour.nbr_chambre as chambres')
            ->get();

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
    /*Enregistrement de l'adresse*/
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
            'idclient' => auth()->user()->idclient, 
            'nom_adresse_client' => $request->input('nom_adresse_client'),
            'rue_client' => $request->input('ligne1'),
            'code_postal_client' => $request->input('code_postal'),
            'ville_client' => $request->input('ville'),
            'pays_client' => $request->input('pays'),
        ]);
    
        $adresse->save();
    
        return redirect()->route('commande.adresse')->with('success', 'Nouvelle adresse ajoutée avec succès.');
    }
    /*Affichage de la facture */
    public function showFacture($numcommande)
    {
        $commande = DB::table('commande')
            ->leftJoin('facture', 'commande.numcommande', '=', 'facture.numcommande')
            ->leftJoin('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->leftJoin('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour') 
            ->where('commande.numcommande', $numcommande)
            ->select(
                'commande.*', 
                'facture.montant_total', 
                'facture.date_facturation', 
                'facture.num_facture',
                'sejour.titresejour'  
            )
            ->first();
    
        if (!$commande) {
            return redirect()->route('commandes.historique')->with('error', 'Commande introuvable.');
        }
    
        return view('facture', compact('commande'));
    }
    
}
