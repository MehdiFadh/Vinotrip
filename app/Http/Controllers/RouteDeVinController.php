<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouteDeVin;
use App\Models\Sejour;
use App\Models\SejourRouteDeVin;
use App\Models\Etape;
use App\Models\ElementEtape;



class RouteDeVinController extends Controller
{
    public function index()

    {
        
        return view('routes_de_vins', [
            'routes_de_vins' => RouteDeVin::all(),
            'sejour_route_vin'=> SejourRouteDeVin::all(),
            'sejours'=>Sejour::all()
        ]);

    }



    public function showByNumRoute($num_route_de_vins)

    {

        // Trouver la route de vin par son numéro

        $route_de_vins = RouteDeVin::findOrFail($num_route_de_vins);


        // Récupérer les séjours associés à cette route de vin
        $sejours = $route_de_vins->sejours;

        $caves = [];
        $etapescaves=[];
        foreach($sejours as $sejour){
            $etapescaves = Etape::where('refsejour', $sejour->refsejour)
                            ->with(['elementEtapes.partenaire.cave'])
                            ->get();
            // Parcours des étapes pour collecter les hébergements
            foreach ($etapescaves as $etape) {
                foreach ($etape->elementEtapes as $elementEtape) {
                    $partenaire = $elementEtape->partenaire;
                    if ($partenaire->cave) {
                        $caves[] = $partenaire; 
                    }
                }
            }
        }
        
        /*foreach($etapescaves as $etapecave){
            $etapeelementetapes = EtapeElementEtape::where('idetape', $etapecave->idetape)
                            ->with(['elementEtapes.partenaire.cave'])
                            ->get();
            
        }
        foreach($etapeelementetapes as $etapeelementcave){
            $elementestapes = ElementEtape::where('idelement_etape', $etapeelementcave->idelement_etape)
                            ->with(['elementEtapes.partenaire.cave'])
                            ->get();
        }*/
       
        
        return view('routedevin.show', compact('route_de_vins', 'sejours','caves'));

    }


}
