<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class CreationCommandeController extends Controller
{
    public function creerCommande(Request $request)
{
    $sejourId = $request->input('sejour_id');
    $sejour = Sejour::find($sejourId);

    if (!$sejour) {
        return redirect()->back()->with('error', 'Séjour introuvable.');
    }

    // Récupération des données
    $user = Auth::user();
    $adultes = $request->input('adultes', 1);
    $enfants = $request->input('enfants', 0);
    $chambres = $request->input('chambres', 1);
    $prixTotal = $request->input('prix_total', 0);

    // Créer la commande
    $commande = Commande::create([
        'sejour_id' => $sejourId,
        'user_id' => $user->id,
        'adultes' => $adultes,
        'enfants' => $enfants,
        'chambres' => $chambres,
        'prix_total' => $prixTotal,
        'status' => 'en attente'::etat_commande_type,
    ]);

    // Ajouter les confirmations des hôtels
    foreach ($sejour->hotels as $hotel) {
        HotelConfirmation::create([
            'commande_id' => $commande->id,
            'hotel_id' => $hotel->id,
        ]);
    }

    return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès.');
}
public function confirmerHotel($commandeId, $hotelId)
{
    $confirmation = HotelConfirmation::where('commande_id', $commandeId)
        ->where('hotel_id', $hotelId)
        ->first();

    if (!$confirmation) {
        return redirect()->back()->with('error', 'Confirmation introuvable.');
    }

    $confirmation->confirmed = true;
    $confirmation->save();

    // Vérifier si tous les hôtels sont confirmés
    $commande = Commande::find($commandeId);
    $tousConfirmes = $commande->hotelsConfirmations->every(function ($confirmation) {
        return $confirmation->confirmée;
    });

    if ($tousConfirmes) {
        $commande->etat_commande = 'confirmée';
        $commande->save();

        // Envoyer un e-mail au client
        $this->envoyerMailClient($commande);
    }

    return redirect()->back()->with('success', 'Hôtel confirmé avec succès.');
}

}
