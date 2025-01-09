<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Sejour;
use App\Models\CategorieParticipant;
use App\Models\CategorieSejour;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('destinations.index', compact('destinations'));
    }

    public function showDestination () {
        return view('sejours', [
            'destinations' => Destination::all()
        ]);
    }

    public function showSejours($id)
    {
        // Trouver la destination avec les séjours
        $destination = Destination::with('sejours')->find($id);

        if (!$destination) {
            abort(404, 'Destination non trouvée');
        }

        return view('destinations.sejour', compact('destination'));
    }

    public function showSejourss($num_destination_sejour)
    {
        // Récupérer la destination sélectionnée
        $destination = Destination::where('num_destination_sejour', $num_destination_sejour)->first();

        // Passer toutes les destinations et la destination sélectionnée à la vue
        $destinations = Destination::all();
        $sejours = Sejour::with('categorieParticipants', 'destination_sejour')->get();
        $categorie_participant = CategorieParticipant::all();
        $categorie_sejour = CategorieSejour::all();

        return view('sejours', [
            'destinations' => $destinations,
            'selectedDestination' => $destination->nom_destination_sejour,
            'sejours' => Sejour::all(),
            'categorie_participant' => CategorieParticipant::all(),
            'categorie_sejour' => CategorieSejour::all(),
            'destinations' => Destination::all(),
        ]);
    }
}
