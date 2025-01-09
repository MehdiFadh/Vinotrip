<?php
namespace App\Http\Controllers;
use App\Models\Partenaire;

class HotelController extends Controller
{
    public function show($id_partenaire)
    {
        // Vérifier que l'ID existe et récupérer le partenaire
        $partenaire = Partenaire::findOrFail($id_partenaire);

        // Assurez-vous que le partenaire a bien un hôtel associé
        $hotel = $partenaire->hotel;

        // Retourner la vue des détails avec les informations du partenaire et de l'hôtel
        return view('hotels.details', ['partenaire' => $partenaire, 'hotel' => $hotel]);
    }
}