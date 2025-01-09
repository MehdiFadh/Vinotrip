<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Ajout de l'importation de Log
use App\Models\Panier;


class PaymentController extends Controller
{

public function createCheckoutSession(Request $request)
{
    $numcommande = $request->input('numcommande');

    if (!$numcommande) {
        return back()->with('error', 'Numéro de commande non fourni.');
    }

    // Récupérer les détails des séjours effectifs
    $effectifs = DB::table('commande_effectif')
        ->join('commande', 'commande_effectif.numcommande', '=', 'commande.numcommande')
        ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
        ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
        ->where('commande_effectif.numcommande', $numcommande)
        ->select(
            'sejour.refsejour as sejour_id',
            'sejour.titresejour',
            'sejour.prix_sejour',
            'commande_sejour.nbr_adulte as adultes',
            'commande_sejour.nbr_enfant as enfants',
            'commande_sejour.nbr_chambre as chambres',
            'commande_effectif.etat_commande as mode_cadeau'
        )
        ->get()
        ->toArray();

    // Récupérer les détails des séjours cadeaux
    $cadeaux = DB::table('commande_cadeau')
        ->join('commande', 'commande_cadeau.numcommande', '=', 'commande.numcommande')
        ->join('commande_sejour', 'commande.numcommande', '=', 'commande_sejour.numcommande')
        ->join('sejour', 'commande_sejour.refsejour', '=', 'sejour.refsejour')
        ->where('commande_cadeau.numcommande', $numcommande)
        ->select(
            'sejour.refsejour as sejour_id',
            'sejour.titresejour',
            'sejour.prix_sejour',
            'commande_sejour.nbr_adulte as adultes',
            'commande_sejour.nbr_enfant as enfants',
            'commande_sejour.nbr_chambre as chambres',
            'commande_cadeau.etat_commande as mode_cadeau'
        )
        ->get()
        ->toArray();

    // Fusionner les données des deux types de commandes
    $panier = array_merge($effectifs, $cadeaux);

    // Calcul du total
    $total = 0;
    foreach ($panier as $item) {
        $total += ($item->adultes+$item->enfants) * $item->prix_sejour;
    }

    // Suite du traitement (comme mise à jour ou création d'une session Stripe)
    return $this->traiterPanierEtPaiement($panier, $numcommande, $total);
}

    
private function traiterPanierEtPaiement(array $panier, $numcommande, $total)
{
    // Exemple de logique de mise à jour ou traitement supplémentaire
    DB::transaction(function () use ($panier, $numcommande, $total) {
        foreach ($panier as $item) {
            DB::table('commande_sejour')
                ->where('numcommande', $numcommande)
                ->where('refsejour', $item->sejour_id)
                ->update([
                    'nbr_adulte' => $item->adultes,
                    'nbr_chambre' => $item->chambres,
                ]);
        }

        // Mise à jour du total dans la facture
        DB::table('facture')
            ->where('num_facture', $numcommande)
            ->update(['montant_total' => $total]);
    });

    // Rediriger vers la session Stripe ou autre
    return $this->creerSessionStripe($panier,$numcommande);
}

    private function creerSessionStripe(array $panier,$numcommande)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Créer une session de paiement Stripe
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $this->createLineItems($panier),  // Détails des produits dans le panier
                'mode' => 'payment',
                'success_url' => route('payment.success',['numcommande' => $numcommande]),
                'cancel_url' => route('payment.cancel'),
            ]);
    
            Log::info('Session de paiement créée', ['session_url' => $session->url]);
    
            // Retourner l'utilisateur vers la session de paiement Stripe
            return redirect()->away($session->url);
        } catch (ApiErrorException $e) {
            Log::error('Erreur lors de la création de la session de paiement', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur lors de la création de la session de paiement.');
        }
    }

   
    /**
     * Créer les line_items pour Stripe à partir du panier
     */
    private function createLineItems($panier)
    {
        $lineItems = [];
        $qte=0;
        foreach ($panier as $item) {

            $totalAdulte = $item->adultes * $item->prix_sejour;
            $totalEnfant = $item->enfants* $item->prix_sejour;
            $prixTotalSejour = $totalAdulte + $totalEnfant;
            $qte+=1;


            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->titresejour,
                    ],
                    'unit_amount' => $prixTotalSejour * 100, // Montant en centimes
                ],
                'quantity' => $qte, // Total des adultes + enfants
            ];
        }

        return $lineItems;
    }
    public function preparation(Request $request)
    {
        // Exemple : Stockez des données dans la session ou en base de données
        $message = $request->input('message_commande', '');
        session()->put('message_commande', $message);
        $panier = session()->get('panier', []);
        session()->put('paiement_prepa', [
            'message_commande' => $message,
            'panier' => $panier,
            'user_id' => auth()->user()->idclient,
            'date_commande' => now(),
        ]);

        return redirect()->route('commande.adresse');
    }
    public function success(Request $request){
        $numcommande = $request->query('numcommande');
        try {
            DB::transaction(function () use ($numcommande) {
                // Mettre à jour l'état dans la table `commande`
                DB::table('commande')
                    ->where('numcommande', $numcommande)
                    ->update([
                        'etat_commande' => true, // Par exemple : true pour payé
                    ]);

                // Mettre à jour l'état dans la table `commande_effectif`
                DB::table('commande_effectif')
                    ->where('numcommande', $numcommande)
                    ->update([
                        'etat_commande' => true, // true pour payé
                    ]);

                // Mettre à jour l'état dans la table `commande_cadeau`
                DB::table('commande_cadeau')
                    ->where('numcommande', $numcommande)
                    ->update([
                        'etat_commande' => true, // : true pour payé
                    ]);
            });
            return redirect()->route('home')->with('success', 'Paiement effectué avec succès ! Commande enregistrée.');
        } catch (\Exception $e) {

            Log::error('Erreur lors de l\'enregistrement de la commande', ['error' => $e->getMessage()]);
            return redirect()->route('panier.afficher')->with('error', 'Une erreur est survenue lors de la mise à jour de la commande.');
        }
    }

    /**
     * Page de succès après paiement
     */
    public function save()
    {
        
        $panier = session()->get('panier', []);
        $idclient = auth()->user()->idclient;
        $dateCommande = now();
        $messageCommande = session()->get('message_commande', ''); // Message récupéré de la session  
        try {
            DB::transaction(function () use ($panier, $idclient, $dateCommande, $messageCommande) {
                // Insérer une commande dans la table `commande`
                DB::table('commande')->insert([
                    'idclient' => $idclient,
                    'date_commande' => $dateCommande,
                    'message_commande' => $messageCommande,
                    'etat_commande' =>null,
                ]);

                // Récupérer l'ID de la commande récemment insérée
                $numcommande = DB::getPdo()->lastInsertId();
                $total=0;

                foreach ($panier as $item) {

                    $totalAdulte = $item['adultes'] * $item['prix_sejour'];  // Prix des adultes
                    $totalEnfant = $item['enfants'] * $item['prix_sejour'];  // Prix des enfants
                    $total += $totalAdulte + $totalEnfant;

                    if (isset($item['mode_cadeau']) && $item['mode_cadeau']) {
                        // Si c'est un cadeau, insérer dans `commande_cadeau`
                        $codeCadeau = Str::random(10); // Générer un code cadeau unique
                        DB::table('commande_cadeau')->insert([
                            'numcommande' => $numcommande,
                            'idclient' => $idclient,
                            'date_commande' => $dateCommande,
                            'message_commande' => $messageCommande,
                            'code_cadeau' => $codeCadeau,
                            'etat_commande' => true,
                        ]);
                    } else {
                        // Sinon, insérer dans `commande_effectif`
                        DB::table('commande_effectif')->insert([
                            'numcommande' => $numcommande,
                            'idclient' => $idclient,
                            'date_commande' => $dateCommande,
                            'message_commande' => $messageCommande,
                            'date_debut_sejour' => $item['date_sejour'], // Si applicable
                            'etat_commande' => null,
                        ]);
                    }

                    // Insérer dans la table `commande_sejour`
                    DB::table('commande_sejour')->insert([
                        'numcommande' => $numcommande,
                        'refsejour' => $item['sejour_id'],
                        'nbr_adulte' => $item['adultes'],
                        'nbr_enfant' => $item['enfants'],
                        'nbr_chambre' => $item['chambres'],
                    ]);
                }
                // Insérer une commande dans la table `commande`
                DB::table('facture')->insert([
                    'num_facture' => $numcommande,
                    'numcommande' => $numcommande,
                    'date_facturation' => $dateCommande,
                    'montant_total' =>$total,
                ]);

            });

            // Nettoyer la session après le succès
            session()->forget('panier');
            session()->forget('message_commande');

            return redirect()->route('home')->with('success', 'Votre commande a été enregistrée.');
        } catch (\Exception $e) {

            Log::error('Erreur lors de l\'enregistrement de la commande', ['error' => $e->getMessage()]);
            return redirect()->route('panier.afficher')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la commande.');
        }
    }

       
    /**
     * Page d'annulation en cas d'échec du paiement
     */
    public function cancel()
    {
        Log::info('Le paiement a été annulé.');
        // L'annulation ne vide pas le panier, il est donc conservé.
        // Retourner à la page panier avec un message d'annulation.
        return redirect()->route('panier.afficher')->with('error', 'Le paiement a été annulé. Vous pouvez réessayer.');
    }


    

}
