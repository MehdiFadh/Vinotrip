<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 
use App\Models\Panier;


class PaymentController extends Controller
{

    public function createCheckoutSession(Request $request)
    {
        $numcommande = $request->input('numcommande');
        if (!$numcommande) 
        {
            return back()->with('error', 'Numéro de commande non fourni.');
        }

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
            'commande_effectif.etat_commande as mode_cadeau')
            ->get()
            ->toArray();
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
                'commande_cadeau.etat_commande as mode_cadeau')
            ->get()
            ->toArray();
        $panier = array_merge($effectifs, $cadeaux);
        $total = 0;
        foreach ($panier as $item) 
        {
            $total += ($item->adultes+$item->enfants) * $item->prix_sejour;
        }
        return $this->traiterPanierEtPaiement($panier, $numcommande, $total);
    }

    
    private function traiterPanierEtPaiement(array $panier, $numcommande, $total)
    {
        DB::transaction(function () use ($panier, $numcommande, $total) {
            foreach ($panier as $item) 
            {
                DB::table('commande_sejour')
                    ->where('numcommande', $numcommande)
                    ->where('refsejour', $item->sejour_id)
                    ->update([
                        'nbr_adulte' => $item->adultes,
                        'nbr_chambre' => $item->chambres,
                    ]);
            }
            DB::table('facture')
                ->where('num_facture', $numcommande)
                ->update(['montant_total' => $total]);
        });
        return $this->creerSessionStripe($panier,$numcommande);
    }

    private function creerSessionStripe(array $panier,$numcommande)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try 
        {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $this->createLineItems($panier), 
                'mode' => 'payment',
                'success_url' => route('payment.success',['numcommande' => $numcommande]),
                'cancel_url' => route('payment.cancel'),
            ]);
            Log::info('Session de paiement créée', ['session_url' => $session->url]);
            return redirect()->away($session->url);
        } 
        catch (ApiErrorException $e) {
            return back()->with('error', 'Erreur lors de la création de la session de paiement.');
        }
    }

    private function createLineItems($panier)
    {
        $lineItems = [];
        $qte=0;
        foreach ($panier as $item) 
        {
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
                    'unit_amount' => $prixTotalSejour * 100, 
                ],
                'quantity' => $qte, 
            ];
        }

        return $lineItems;
    }
    public function preparation(Request $request)
    {
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
        try 
        {
            DB::transaction(function () use ($numcommande) 
            {
                DB::table('commande')
                    ->where('numcommande', $numcommande)
                    ->update([
                        'etat_commande' => true, 
                    ]);

                DB::table('commande_effectif')
                    ->where('numcommande', $numcommande)
                    ->update([
                        'etat_commande' => true,
                    ]);

                DB::table('commande_cadeau')
                    ->where('numcommande', $numcommande)
                    ->update([
                        'etat_commande' => true, 
                    ]);
            });
            return redirect()->route('home')->with('success', 'Paiement effectué avec succès ! Commande enregistrée.');
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('panier.afficher')->with('error', 'Une erreur est survenue lors de la mise à jour de la commande.');
        }
    }


    public function save()
    {
        $panier = session()->get('panier', []);
        $idclient = auth()->user()->idclient;
        $dateCommande = now();
        $messageCommande = session()->get('message_commande', '');  
        try 
        {
            DB::transaction(function () use ($panier, $idclient, $dateCommande, $messageCommande) {
                DB::table('commande')->insert([
                    'idclient' => $idclient,
                    'date_commande' => $dateCommande,
                    'message_commande' => $messageCommande,
                    'etat_commande' =>null,
                ]);
                $numcommande = DB::getPdo()->lastInsertId();
                $total=0;
                foreach ($panier as $item) {
                    $totalAdulte = $item['adultes'] * $item['prix_sejour'];  
                    $totalEnfant = $item['enfants'] * $item['prix_sejour'];  
                    $total += $totalAdulte + $totalEnfant;
                    if (isset($item['mode_cadeau']) && $item['mode_cadeau']) 
                    {
                        $codeCadeau = Str::random(10); 
                        DB::table('commande_cadeau')->insert([
                            'numcommande' => $numcommande,
                            'idclient' => $idclient,
                            'date_commande' => $dateCommande,
                            'message_commande' => $messageCommande,
                            'code_cadeau' => $codeCadeau,
                            'etat_commande' => true,
                        ]);
                    } 
                    else 
                    {
                        DB::table('commande_effectif')->insert([
                            'numcommande' => $numcommande,
                            'idclient' => $idclient,
                            'date_commande' => $dateCommande,
                            'message_commande' => $messageCommande,
                            'date_debut_sejour' => $item['date_sejour'], 
                            'etat_commande' => null,
                        ]);
                    }
                    DB::table('commande_sejour')->insert([
                        'numcommande' => $numcommande,
                        'refsejour' => $item['sejour_id'],
                        'nbr_adulte' => $item['adultes'],
                        'nbr_enfant' => $item['enfants'],
                        'nbr_chambre' => $item['chambres'],
                    ]);
                }
                DB::table('facture')->insert([
                    'num_facture' => $numcommande,
                    'numcommande' => $numcommande,
                    'date_facturation' => $dateCommande,
                    'montant_total' =>$total,
                ]);
            });
            session()->forget('panier');
            session()->forget('message_commande');
            return redirect()->route('home')->with('success', 'Votre commande a été enregistrée.');
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('panier.afficher')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la commande.');
        }
    }

    public function cancel()
    {
        return redirect()->route('panier.afficher')->with('error', 'Le paiement a été annulé. Vous pouvez réessayer.');
    }
}