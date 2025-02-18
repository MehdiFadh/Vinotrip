<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sejour;
use App\Models\BonDeReduction;
use App\Models\UtilisationBon;

class PanierController extends Controller
{
    
    public function ajouterArticle(Request $request)
    {
        
        if ($request->input('type') === 'cheque_cadeau') {
            $montant = $request->input('montant');
            $offertPar = $request->input('offert_par', null);
            $message = $request->input('message', null);
            $format = $request->input('format', 'e-coffret');

            if (!$montant || $montant <= 0) {
                return redirect()->back()->with('error', 'Le montant du chèque cadeau est invalide.');
            }

            $panier = session()->get('panier', []);
            $panier[] = [
                'type' => 'cheque_cadeau',
                'montant' => $montant,
                'offert_par' => $offertPar,
                'message' => $message,
                'format' => $format,
            ];

            session()->put('panier', $panier);

            return redirect()->route('panier.afficher')->with('success', 'Chèque cadeau ajouté au panier avec succès.');
        }
        $prixGastronomie=124;
        $prixDiner=20;
        $prixActivite=40;
        $sejourId = $request->input('sejour_id');
        $sejour = Sejour::find($sejourId);
        if (!$sejour) {
            return redirect()->back()->with('error', 'Séjour introuvable.');
        }
    
        $adultes = $request->input('adultes', 1);
        $enfants = $request->input('enfants', 0);
        $chambres = $request->input('chambres', 1);
        $message = $request->input('message', '');
        $modeCadeau = $request->boolean('mode_cadeau', false);
        $dateSejour = $modeCadeau ? null : $request->input('date_sejour');
    
        $dinerGastronomique = $request->input('diner_gastronomique', 'non') === 'oui' ? $prixGastronomie : 0;
        $diner = $request->input('diner', 'non') === 'oui' ? $prixDiner : 0;
        $activite = $request->input('activite', 'activite1') === 'activite1' ? $prixActivite : 0;
    
        $totalPersonnes = $adultes + $enfants;
        if ($totalPersonnes > 10) {
            return redirect()->back()->with('error', 'Le nombre total de personnes ne peut pas dépasser 10.');
        }
    
        if (!$modeCadeau && !$dateSejour) {
            return redirect()->back()->with('error', 'Veuillez sélectionner une date pour le séjour.');
        }
    
        $prixOptions = ($dinerGastronomique + $diner + $activite) * $totalPersonnes;
    
        $panier = session()->get('panier', []);
        $panier[$sejourId] = [
            'sejour_id' => $sejourId,
            'titresejour' => $sejour->titresejour,
            'prix_sejour' => $sejour->prix_sejour,
            'url_photo_sejour' => $sejour->url_photo_sejour,
            'adultes' => $adultes,
            'enfants' => $enfants,
            'chambres' => $chambres,
            'message' => $message,
            'mode_cadeau' => $modeCadeau,
            'date_sejour' => $dateSejour,
            'options' => [
                'diner_gastronomique' => $dinerGastronomique > 0,
                'diner' => $diner > 0,
                'activite' => $activite > 0 ? 'Visite des vignobles' : 'Fourchette et tire-bouchon en Côte de Nuits'
            ],
            'prix_total' => ($sejour->prix_sejour * $totalPersonnes) + $prixOptions, 
        ];
    
        session()->put('offrir', $modeCadeau);
        session()->put('panier', $panier);
    
        return redirect()->route('panier.afficher')->with('success', 'Séjour ajouté au panier avec succès.');
    }
    
    
    public function afficher()
    {
        $panier = session()->get('panier', []);
        $total = 0;
        $prixGastronomie=124;
        $prixDiner=20;
        $prixActivite=40;
        $totalOptions=0;
        $messageCommande = $panier['message_commande'] ?? null;
    
        unset($panier['message_commande']);
    
        foreach ($panier as $id => &$details) {
            if (is_array($details)) {
                $details['chambres'] = $details['chambres'] ?? 1;
                $details['adultes'] = $details['adultes'] ?? 1;
                $details['enfants'] = $details['enfants'] ?? 0;
                
    
                if($details['options']['diner']===1)
                    $totalOptions+=$prixDiner*($details['adultes']+$details['enfants']);
                if($details['options']['diner_gastronomique']===1)
                    $totalOptions+=$prixGastronomie*($details['adultes']+$details['enfants']);
                if($details['options']['activite']===1)
                    $totalOptions+=$prixActivite*($details['adultes']+$details['enfants']);

                $totalAdulte = $details['adultes'] * $details['prix_sejour'];
                $totalEnfant = $details['enfants'] * $details['prix_sejour'];
                $details['prix_total'] = $totalAdulte + $totalEnfant+$totalOptions;
    
                $total += $details['prix_total'];
            }
        }
    
        session()->put('panier', $panier);
    
        return view('panier', compact('panier', 'total', 'messageCommande'));
    }
    
    public function supprimer(Request $request)
    {
        $sejourId = $request->input('sejour_id');
        $panier = session()->get('panier', []);
    
        if (isset($panier[$sejourId])) {
            unset($panier[$sejourId]);
            session()->put('panier', $panier);
            return redirect()->route('panier.afficher')->with('success', 'Séjour retiré du panier.');
        }
    
        return redirect()->route('panier.afficher')->with('error', 'Séjour introuvable dans le panier.');
    }
    

    public function modifier(Request $request )
    {
        $sejourId = $request->input('sejour_id');
        $panier = session()->get('panier', []);
    
        if (isset($panier[$sejourId])) {
            $adultes = $request->input('adultes', $panier[$sejourId]['adultes'] ?? 1);
            $enfants = $request->input('enfants', $panier[$sejourId]['enfants'] ?? 0);
            $chambres = $request->input('chambres', $panier[$sejourId]['chambres'] ?? 1);
           
    
            if ($adultes + $enfants > 10) {
                return redirect()->route('panier.afficher')->with('info', 'Vous avez atteint la limite de 10 personnes. Contactez-nous pour un séjour adapté.');
            }
    
            if ($chambres > 5) {
                return redirect()->route('panier.afficher')->with('info', 'Vous avez atteint la limite de 5 chambres. Contactez-nous pour un séjour adapté.');
            }
    
            $panier[$sejourId]['adultes'] = $adultes;
            $panier[$sejourId]['enfants'] = $enfants;
            $panier[$sejourId]['chambres'] = $chambres;

            if (isset($panier[$sejourId]['mode_cadeau']) && $panier[$sejourId]['mode_cadeau'] == 0) {
                $date_sejour = $request->input('date_sejour', $panier[$sejourId]['date_sejour'] ?? date('Y-m-d'));  
                $panier[$sejourId]['date_sejour'] = $date_sejour;  
            }
        
    
            session()->put('panier', $panier);
    
            return redirect()->route('panier.afficher')->with('success', 'Panier mis à jour avec succès.');
        }   
        return redirect()->route('panier.afficher')->with('error', 'Séjour introuvable dans le panier.');
    }     
    

    public function appliquerCodeReduction(Request $request)
    {
        $codeReduction = $request->input('codeReduction');

        $bon = BonDeReduction::where('code_bon_de_reduction', $codeReduction)
            ->where('date_creation', '>=', now()->subMonths(18))
            ->first();

        if ($bon) {
            $montantBon = $bon->montant_bon;
            
            session()->put('code_reduction', $codeReduction);
            session()->put('montant_reduction', $montantBon);

            /*$commande = new UtilisationBon([
                'numcommande' => 1234, 
                'code_bon_de_reduction' => $codeReduction
            ]);
            $commande->save();*/

            return redirect()->route('panier.afficher')->with('success', "Le code de réduction de $montantBon € a été appliqué.");
        } else {
            return redirect()->route('panier.afficher')->with('error', "Le code de réduction est invalide ou expiré.");
        }
    }
    
    public function ajouterChequeCadeau(Request $request)
    {
        $format = $request->input('format', 'e-coffret'); 
        $montant = $request->input('montant', 50); 
        $image = '/img/e-coffret.png'; 
        
        $panier = session()->get('panier', []);
        $panier[] = [
            'nom' => 'Format cadeau e-coffret',
            'prix' => $montant,
            'image' => $image,
        ];
        
        session()->put('panier', $panier);
        
        return redirect()->route('panier.afficher')->with('success', 'Chèque cadeau ajouté au panier.');
    }

}
