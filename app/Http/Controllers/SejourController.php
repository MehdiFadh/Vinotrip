<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Http\Request;
use App\Models\Sejour;
use App\Models\CategorieParticipant;
use App\Models\Destination;
use App\Models\CategorieSejour;
use App\Models\Partenaire;
use App\Models\Hotel;
use App\Models\Etape;
use App\Models\ElementEtape;
use App\Models\EtapeElementEtape;
use App\Models\Cave;
use App\Models\Reservation;
use App\Models\ThemeSejour;
use App\Models\RouteDeVin;
use Illuminate\Support\Facades\Log;
use App\Mail\DisponibiliteTousHotelMail;

class SejourController extends Controller
{
    public function index()
    {
        $sejours = Sejour::where('statut', 'valide')
                        ->withCount('etapes')
                        ->with('categorieParticipants', 'destination_sejour')
                        ->orderBy('titresejour', 'asc')
                        ->get();
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
        $sejour = Sejour::where('titresejour', $titresejour)->firstOrFail();
        $etapes = Etape::where('refsejour', $sejour->refsejour)
                       ->with(['elementEtapes.partenaire.hotel', 'elementEtapes.partenaire.cave'])
                       ->orderBy('titre_etape', 'asc')
                       ->get();
        $hotels = $this->collectHebergements($etapes, 'hotel');
        $caves = $this->collectHebergements($etapes, 'cave');
        $avis = $sejour->avis()->get();    
        return view('sejour.show', compact('sejour', 'hotels', 'caves', 'avis'));
    }

    public function showByRefSejour($refsejour)
    {
        $sejour = Sejour::where('refsejour', $refsejour)->firstOrFail();
        $etapes = Etape::where('refsejour', $refsejour)
                        ->with(['elementEtapes.partenaire.hotel'])
                        ->orderBy('titre_etape', 'asc')
                        ->get();
        $etapescave = Etape::where('refsejour', $refsejour)
                        ->with(['elementEtapes.partenaire.cave'])    
                        ->orderBy('titre_etape', 'asc')
                        ->get();
        $hotels = $this->collectHebergements($etapes, 'hotel');
        $caves = $this->collectHebergements($etapescave, 'cave');
        return view('sejour.show', compact('sejour', 'hotels', 'caves', 'etapes'));
    }

    public function reserverEffectif(Request $request)
    {
        $validatedData = $request->validate([
            'sejour_id' => 'required|exists:sejours,refsejour',
            'date' => 'required|date',
            'date_debut_sejour' => 'required|date|after:today', 
            'adultes' => 'required|integer|min:1',
            'enfants' => 'nullable|integer|min:0',
            'chambres' => 'required|integer|min:1',
        ]);
        Reservation::create($validatedData);
        return redirect()->route('sejour.details', $validatedData['sejour_id'])->with('success', 'Réservation effectuée avec succès !');
    }

    public function showEffectifDetails($refsejour)
    {
        $sejour = Sejour::where('refsejour', $refsejour)->firstOrFail();
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
        return $hebergements->unique('id_partenaire'); 
    }

    public function create()
    {
        return view('sejour.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idtheme' => 'required|integer',
            'num_destination_sejour' => 'required|integer',
            'titresejour' => 'required|string|max:255',
            'descriptionsejour' => 'required|string',
            'prix_sejour' => 'required|numeric|min:0',
            'url_photo_sejour' => 'nullable|url',
        ]);
        $sejour = Sejour::create($validatedData);
        Cache::put('sejour_en_attente_' . $sejour->refsejour, $sejour, now()->addHours(48));
        session()->flash('status', 'Le séjour est en attente de validation.');
        return redirect()->route('sejours.create')->with('success', 'Le séjour a été créé avec succès et est en attente de validation.');
    }
    
    public function showSejoursEnAttente()
    {
        $sejoursEnAttente = Sejour::where('statut', 'en_attente')->get();
        return view('admin.sejours_en_attente', compact('sejoursEnAttente'));
    }

    public function showSejoursEnAttente2()
    {
        $sejoursEnAttente = Sejour::where('statut', 'en_attente')->get();
        return view('admin.sejours_en_attente2', compact('sejoursEnAttente'));
    }

    public function editCompleteDetails($refsejour)
    {
        $sejour = Sejour::with([
            'destination_sejour:num_destination_sejour,nom_destination_sejour',
            'categorieSejours:idcategoriesejour,type_sejour',
            'routesDeVins:num_route_de_vins,nom_route_de_vins',
            'categorieParticipants:idcategorie_participant,type_participant',
        ])->findOrFail($refsejour);
        $destinations = Destination::select('num_destination_sejour', 'nom_destination_sejour')->get();
        $categoriesSejours = CategorieSejour::select('idcategoriesejour', 'type_sejour')->get();
        $routes = RouteDeVin::select('num_route_de_vins', 'nom_route_de_vins')->get();
        $categoriesParticipants = CategorieParticipant::select('idcategorie_participant', 'type_participant')->get();
        return view('admin.edit_sejour_details', compact(
            'sejour', 'destinations', 'categoriesSejours', 'routes', 'categoriesParticipants'
        ));
    }

    public function CompleteDetails($refsejour)
    {
        $sejour = Sejour::with([
            'destination_sejour:num_destination_sejour,nom_destination_sejour',
            'categorieSejours:idcategoriesejour,type_sejour',
            'routesDeVins:num_route_de_vins,nom_route_de_vins',
            'categorieParticipants:idcategorie_participant,type_participant',
        ])->findOrFail($refsejour);
        $destinations = Destination::select('num_destination_sejour', 'nom_destination_sejour')->get();
        $categoriesSejours = CategorieSejour::select('idcategoriesejour', 'type_sejour')->get();
        $routes = RouteDeVin::select('num_route_de_vins', 'nom_route_de_vins')->get();
        $categoriesParticipants = CategorieParticipant::select('idcategorie_participant', 'type_participant')->get();
        return view('admin.sejour_details', compact(
            'sejour', 'destinations', 'categoriesSejours', 'routes', 'categoriesParticipants'
        ));
    }
    
    public function updateCompleteDetails(Request $request, $refsejour)
    {
        $validatedData = $request->validate([
            'type_sejour' => 'required|string',
            'nom_destination_sejour' => 'required|string',
            'nom_route_de_vins' => 'required|string',
            'type_participant' => 'required|string',
        ]);
        $sejour = Sejour::findOrFail($refsejour);
        $destinationId = Destination::where('nom_destination_sejour', $validatedData['nom_destination_sejour'])->value('num_destination_sejour');
        $sejour->update([
            'num_destination_sejour' => $destinationId,
        ]);
        if (isset($validatedData['type_sejour'])) 
        {
            $categorieId = $validatedData['type_sejour'];
            $sejour->categorieSejours()->sync([$categorieId]);
        }
        if (isset($validatedData['nom_route_de_vins'])) 
        {
            $route = RouteDeVin::where('nom_route_de_vins', $validatedData['nom_route_de_vins'])->first();
            if ($route) 
            {
                $sejour->routesDeVins()->sync([$route->num_route_de_vins]);
            }
            else 
            {
            }
        }
    
        if (isset($validatedData['type_participant'])) 
        {
            $categorieId = $validatedData['type_participant'];
            $sejour->categorieParticipants()->sync([$categorieId]);
        }
            return redirect()->route('sejours.en_attente2')->with('success', 'Détails du séjour mis à jour avec succès.');
    }
    
        
    public function envoyerMailTousPartenaires()
    {
        $resultats = DB::table('vinotrip_schema.partenaire')
            ->select('mailpartenaire')
            ->distinct()
            ->get();
        if ($resultats->isNotEmpty()) 
        {
            foreach ($resultats as $result) 
            {
                $mailPartenaire = $result->mailpartenaire;

                Mail::to($mailPartenaire)->send(new DisponibiliteTousHotelMail());
            }

            session()->flash('success', 'Les emails de disponibilité ont été envoyés à tous les partenaires.');
        } 
        else 
        {
            session()->flash('error', 'Aucun partenaire trouvé.');
        }
        return redirect()->route('sejours.en_attente2');
    }

    public function validerSejour($refsejour)
    {
        $sejour = Sejour::findOrFail($refsejour);
        $sejour->statut = 'valide';
        $sejour->save();
        return redirect()->back()->with('success', 'Le séjour a été validé avec succès !');
    }

    public function refuserSejour($refsejour)
    {
        $sejour = Sejour::findOrFail($refsejour);
        $sejour->statut = 'refuse';
        $sejour->save();
        return redirect()->back()->with('success', 'Le séjour a été refusé !');
    }
}
