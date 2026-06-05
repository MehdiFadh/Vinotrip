<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReportController extends Controller
{
    public function index()
    {
        $salesData = DB::table('commande')
            ->join('facture', 'commande.numcommande', '=', 'facture.numcommande')
            ->select(
                DB::raw('DATE_TRUNC(\'month\', commande.date_commande) as mois'),
                DB::raw('COUNT(commande.numcommande) as ventes'),
                DB::raw('SUM(facture.montant_total) as revenus')
            )
            ->groupBy('mois')
            ->orderBy('mois', 'desc')
            ->take(12)
            ->get();
        $mois = [];
        $ventes = [];
        $revenus = [];

        foreach ($salesData as $data) 
        {
            $mois[] = Carbon::parse($data->mois)->format('M Y'); 
            $ventes[] = $data->ventes;
            $revenus[] = $data->revenus;
        }

        return view('rapport-ventes.index', compact('mois', 'ventes', 'revenus'));
    }
    public function sejourDetails()
    {
        $details = DB::table('commande')
            ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
            ->join('destination_sejour', 'sejour.num_destination_sejour', '=', 'destination_sejour.num_destination_sejour')
            ->join('sejour_categorie_sejour', 'sejour.refsejour', '=', 'sejour_categorie_sejour.refsejour')
            ->join('categorie_sejour', 'sejour_categorie_sejour.idcategoriesejour', '=', 'categorie_sejour.idcategoriesejour')
            ->join('sejour_categorie_participant', 'sejour.refsejour', '=', 'sejour_categorie_participant.refsejour')
            ->join('categorie_participant', 'sejour_categorie_participant.idcategorie_participant', '=', 'categorie_participant.idcategorie_participant')
            ->select(
                'destination_sejour.nom_destination_sejour as destination',
                'categorie_sejour.type_sejour as categorie_sejour',
                'categorie_participant.type_participant as categorie_participant',
                'sejour.titresejour as sejour',
                DB::raw('COUNT(commande_sejour.numcommande) as nombre_ventes'),
                DB::raw('SUM(commande_sejour.nbr_adulte * sejour.prix_sejour) as revenu')
            )
            ->groupBy('destination_sejour.nom_destination_sejour', 'categorie_sejour.type_sejour', 'categorie_participant.type_participant', 'sejour.titresejour')
            ->orderBy('destination_sejour.nom_destination_sejour')
            ->get();
        $destinations = DB::table('destination_sejour')->pluck('nom_destination_sejour');
        $categoriesSejour = DB::table('categorie_sejour')->pluck('type_sejour');
        $categoriesParticipant = DB::table('categorie_participant')->pluck('type_participant');
        return view('rapport-ventes.sejour-details', compact('details', 'destinations', 'categoriesSejour', 'categoriesParticipant'));
    }


    public function generateReportPDF()
    {
        $salesData = DB::table('commande')
            ->join('facture', 'commande.numcommande', '=', 'facture.numcommande')
            ->select(
                DB::raw('DATE_TRUNC(\'month\', commande.date_commande) as mois'),
                DB::raw('COUNT(commande.numcommande) as ventes'),
                DB::raw('SUM(facture.montant_total) as revenus')
            )
            ->groupBy('mois')
            ->orderBy('mois', 'desc')
            ->take(12)
            ->get();
        $mois = [];
        $ventes = [];
        $revenus = [];

        foreach ($salesData as $data) 
        {
            $mois[] = \Carbon\Carbon::parse($data->mois)->format('F Y');
            $ventes[] = $data->ventes;
            $revenus[] = $data->revenus;
        }
        $pdf = Pdf::loadView('rapport-ventes.pdf', compact('mois', 'ventes', 'revenus'));
        $filePath = storage_path('app/public/Rapport_Ventes.pdf');
        $pdf->save($filePath);

        return $filePath;
    }

    public function rapportVentesVignobles()
    {
        $vignobles = DB::table('sejour AS s')
            ->join('commande_sejour AS cs', 's.refsejour', '=', 'cs.refsejour')
            ->join('commande AS c', 'cs.numcommande', '=', 'c.numcommande')
            ->join('sejour_cat_vignoble AS scv', 'scv.refsejour', '=', 's.refsejour')
            ->join('categorie_vignoble AS cv', 'cv.idcategorievignoble', '=', 'scv.idcategorievignoble')
            ->select('cv.type_vignoble AS vignoble',
                DB::raw('COUNT(cs.refsejour) AS nombre_sejours'),
                DB::raw('SUM(cs.nbr_adulte * s.prix_sejour + cs.nbr_enfant * s.prix_sejour) AS revenus')
            )
            ->whereMonth('c.date_commande', now()->month)
            ->whereYear('c.date_commande', now()->year)
            ->groupBy('cv.type_vignoble')
            ->orderBy('nombre_sejours', 'desc')
            ->get();
        return view('rapport-ventes.vignobles', compact('vignobles'));
    }

    public function rapportVentesZoneGeographique()
    {
        $zonesGeographiques = DB::table('commande')
            ->join('client', 'commande.idclient', '=', 'client.idclient')
            ->join('adresse_client', 'client.idclient', '=', 'adresse_client.idclient')
            ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
            ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
            ->select(
                'adresse_client.pays_client as pays',
                'adresse_client.region_client as region',
                'adresse_client.ville_client as ville',
                DB::raw('AVG(adresse_client.latitude) as latitude'),
                DB::raw('AVG(adresse_client.longitude) as longitude'),
                DB::raw('COUNT(commande_sejour.numcommande) as nombre_ventes'),
                DB::raw('SUM(commande_sejour.nbr_adulte * sejour.prix_sejour + commande_sejour.nbr_enfant * sejour.prix_sejour) as revenus')
            )
            ->whereMonth('commande.date_commande', now()->month)
            ->whereYear('commande.date_commande', now()->year)
            ->groupBy('adresse_client.pays_client', 'adresse_client.region_client', 'adresse_client.ville_client') 
            ->orderBy('nombre_ventes', 'desc')
            ->get();
        return view('rapport-ventes.zone-geographique', compact('zonesGeographiques'));
    }
}