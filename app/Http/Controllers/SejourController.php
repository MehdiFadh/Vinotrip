<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use App\Models\Sejour;
use App\Models\CategorieParticipant;
use App\Models\Destination;
use App\Models\CategorieSejour;
use App\Models\Partenaire;
use App\Models\Hotel;
use App\Models\Etape;
use App\Models\ElementEtape;
use App\Models\Cave;
use App\Models\Reservation;

class SejourController extends Controller
{
    public function index()
    {
        // Récupérer uniquement les séjours avec le statut 'valide', avec les catégories de participants et les destinations
        $sejours = Sejour::where('statut', 'valide')
                        ->withCount('etapes')
                        ->with('categorieParticipants', 'destination_sejour')
                        ->orderBy('titresejour', 'asc')
                        ->get();
    
        // Récupérer les autres informations nécessaires (catégories, destinations, etc.)
        $categorie_participant = CategorieParticipant::all();
        $categorie_sejour = CategorieSejour::all();
    
        return view('sejours', [
            'sejours' => $sejours,
            'categorie_participant' => $categorie_participant,
            'categorie_sejour' => $categorie_sejour,
            'destinations' => Destination::all(),
        ]);
    }
    

    public function showByTitre($titresejour)
    {
        // Recherche du séjour par titre
        $sejour = Sejour::where('titresejour', $titresejour)->firstOrFail();
    
        // Charger les étapes
        $etapes = Etape::where('refsejour', $sejour->refsejour)
                       ->with(['elementEtapes.partenaire.hotel', 'elementEtapes.partenaire.cave'])
                       ->orderBy('titre_etape', 'asc')
                       ->get();
    
        // Collecter les hôtels et caves
        $hotels = $this->collectHebergements($etapes, 'hotel');
        $caves = $this->collectHebergements($etapes, 'cave');
    
        // Charger les avis
        $avis = $sejour->avis()->get();
    
        return view('sejour.show', compact('sejour', 'hotels', 'caves', 'avis'));
    }

    public function showByRefSejour($refsejour)
    {
        // Recherche du séjour avec la référence
        $sejour = Sejour::where('refsejour', $refsejour)->firstOrFail();
    
        // Récupérer les étapes du séjour avec les partenaires et leurs hôtels associés
        $etapes = Etape::where('refsejour', $refsejour)
                        ->with(['elementEtapes.partenaire.hotel'])
                        ->orderBy('titre_etape', 'asc')
                        ->get();
    
        // Charger les étapes et collecter les caves associées
        $etapescave = Etape::where('refsejour', $refsejour)
                        ->with(['elementEtapes.partenaire.cave'])    
                        ->orderBy('titre_etape', 'asc')
                        ->get();
    
        // Collecte des hôtels et des caves séparément
        $hotels = $this->collectHebergements($etapes, 'hotel');
        $caves = $this->collectHebergements($etapescave, 'cave');
    
        return view('sejour.show', compact('sejour', 'hotels', 'caves', 'etapes'));
    }

    public function reserverEffectif(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'sejour_id' => 'required|exists:sejours,refsejour',  // Correction de la validation de l'ID du séjour
            'date' => 'required|date',
            'date_debut_sejour' => 'required|date|after:today', 
            'adultes' => 'required|integer|min:1',
            'enfants' => 'nullable|integer|min:0',
            'chambres' => 'required|integer|min:1',
        ]);

        // Logique pour enregistrer la réservation (vous devez créer la table Reservation et le modèle)
        Reservation::create($validatedData);

        return redirect()->route('sejour.details', $validatedData['sejour_id'])->with('success', 'Réservation effectuée avec succès !');
    }

    public function showEffectifDetails($refsejour)
    {
        // Recherche du séjour avec la référence
        $sejour = Sejour::where('refsejour', $refsejour)->firstOrFail();
    
        // Charger les étapes et partenaires (hôtels et caves)
        $etapes = Etape::where('refsejour', $refsejour)
                       ->with(['elementEtapes.partenaire.hotel', 'elementEtapes.partenaire.cave'])
                       ->orderBy('titre_etape', 'asc')
                       ->get();
    
        $hotels = $this->collectHebergements($etapes, 'hotel');
        $caves = $this->collectHebergements($etapes, 'cave');
    
        return view('sejour_effectif', compact('sejour', 'hotels', 'caves'));
    }

    private function collectHebergements($etapes, $type = null)
    {
        $hebergements = collect();
        foreach ($etapes as $etape) {
            foreach ($etape->elementEtapes as $elementEtape) {
                $partenaire = $elementEtape->partenaire;
                if ($partenaire) {
                    if ($type === 'hotel' && $partenaire->hotel) {
                        $hebergements->push($partenaire);
                    } elseif ($type === 'cave' && $partenaire->cave) {
                        $hebergements->push($partenaire);
                    } elseif (is_null($type)) {
                        $hebergements->push($partenaire);
                    }
                }
            }
        }

        return $hebergements->unique('id_partenaire'); // Suppression des doublons
    }

    public function create()
    {
        // Récupère les informations nécessaires pour créer un séjour
        return view('sejour.create');
    }

    public function store(Request $request)
    {
        // Validation des données du séjour
        $validatedData = $request->validate([
            'idtheme' => 'required|integer',
            'num_destination_sejour' => 'required|integer',
            'titresejour' => 'required|string|max:255',
            'descriptionsejour' => 'required|string',
            'prix_sejour' => 'required|numeric|min:0',
            'url_photo_sejour' => 'nullable|url',
        ]);
    
        // Créer un séjour
        $sejour = Sejour::create($validatedData);
    
        // Stocker le séjour en attente dans le cache pendant 48 heures
        Cache::put('sejour_en_attente_' . $sejour->refsejour, $sejour, now()->addHours(48));
    
        // Ajouter une session pour indiquer que le séjour est en attente
        session()->flash('status', 'Le séjour est en attente de validation.');
    
        // Rediriger vers la page de création avec un message de succès
        return redirect()->route('sejours.create')->with('success', 'Le séjour a été créé avec succès et est en attente de validation.');
    }
    
    public function showSejoursEnAttente()
    {
        // Récupérer tous les séjours en attente (statut 'en_attente')
        $sejoursEnAttente = Sejour::where('statut', 'en_attente')->get();
    
        return view('admin.sejours_en_attente', compact('sejoursEnAttente'));
    }
    public function validerSejour($refsejour)
    {
        // Trouver le séjour à valider
        $sejour = Sejour::findOrFail($refsejour);

        // Marquer le séjour comme validé
        $sejour->statut = 'valide';
        $sejour->save();

        return redirect()->back()->with('success', 'Le séjour a été validé avec succès !');
    }

    public function refuserSejour($refsejour)
    {
        // Trouver le séjour à refuser
        $sejour = Sejour::findOrFail($refsejour);

        // Marquer le séjour comme refusé
        $sejour->statut = 'refuse';
        $sejour->save();

        return redirect()->back()->with('success', 'Le séjour a été refusé !');
    }
}
