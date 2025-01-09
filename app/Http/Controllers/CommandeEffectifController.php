<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CommandeEffectif;
use App\Models\Commande;
use App\Models\CommandeSejour;
use App\Models\Sejour;
use App\Models\Client;
use App\Models\Etape;
use App\Models\Destination;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\DisponibiliteHotelMail;
use App\Mail\ReglementSejour;
use App\Mail\DemandeAvisHotelMail;
use App\Mail\CarnetRouteMail;
use App\Mail\ValidationPartenaireMail;
use App\Mail\RemboursementClientMail;






class CommandeEffectifController extends Controller
{
    public function afficherCommande()
    {
        // Récupérer les commandes avec leur facture
        $commandes = DB::table('commande_effectif')
            ->orderBy('commande_effectif.date_commande', 'desc')
            ->select(
                'commande_effectif.*', // Toutes les colonnes de commande
            )
            ->get();

        // Retourner la vue avec les commandes récupérées
        return view('commandesEffectif.affichage', compact('commandes'));
    }
    
        // Méthode pour mettre à jour l'état de la commande à "Accepté"
        public function accepterCommande($numcommande)
        {
            try {
                DB::table('commande')
                    ->where('numcommande', $numcommande)
                    ->update(['etat_commande' => true]); // Mettre à jour l'état à "accepté"
    
                return redirect()->route('commandes.index')->with('success', 'La commande a été acceptée.');
            } catch (\Exception $e) {
                Log::error("Erreur lors de l'acceptation de la commande {$numcommande}: " . $e->getMessage());
                return redirect()->route('commandes.index')->with('error', 'Erreur lors de l\'acceptation de la commande.');
            }
        }
    
        // Méthode pour annuler une commande
        public function annulerCommande($numcommande)
        {
            try {
                DB::table('commande')
                    ->where('numcommande', $numcommande)
                    ->update(['etat_commande' => false]); // Mettre à jour l'état à "annulé"
    
                return redirect()->route('commandes.index')->with('success', 'La commande a été annulée.');
            } catch (\Exception $e) {
                Log::error("Erreur lors de l'annulation de la commande {$numcommande}: " . $e->getMessage());
                return redirect()->route('commandes.index')->with('error', 'Erreur lors de l\'annulation de la commande.');
            }
        }

        public function envoyerMailDisponibilite($numcommande)
        {
            $result = DB::select("SELECT p.mailpartenaire FROM vinotrip_schema.commande_effectif ce
                                    JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                    JOIN vinotrip_schema.commande_sejour cs ON c.numcommande = cs.numcommande
                                    JOIN vinotrip_schema.sejour s ON s.refsejour = cs.refsejour
                                    JOIN vinotrip_schema.etape e ON e.refsejour = s.refsejour
                                    JOIN vinotrip_schema.etape_element_etape a ON e.id_etape = a.id_etape
                                    JOIN vinotrip_schema.element_etape aa ON a.idelement_etape = aa.idelement_etape
                                    JOIN vinotrip_schema.partenaire p ON p.id_partenaire = aa.id_partenaire
                                    JOIN vinotrip_schema.hotel h ON h.id_partenaire = p.id_partenaire
                                    WHERE ce.numcommande = " .$numcommande." limit 1")[0];
                
            if ($result) {
                $mailPartenaire = $result->mailpartenaire;

                Mail::to($mailPartenaire)->send(new DisponibiliteHotelMail());

                session()->flash('success', 'Le mail de disponibilité à été envoyée.');

            } else {
                session()->flash('error', 'Aucun partenaire trouvé pour cette commande.');
            }

            return redirect()->route('commandesEffectif.afficherCommande');
        }



        public function envoyerReglementsejour($numcommande)
        {
            $result = DB::select("SELECT cl.mailclient FROM vinotrip_schema.commande_effectif ce
                                    JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                    JOIN vinotrip_schema.client cl ON c.idclient = cl.idclient                            
                                    WHERE ce.numcommande = " .$numcommande." limit 1")[0];
                
            if ($result) {
                $mailClient = $result->mailclient;

                Mail::to($mailClient)->send(new ReglementSejour());

                session()->flash('success', 'Le mail pour le règlement a bien été envoyé au client.');

            } else {
                session()->flash('error', 'Aucun client trouvé pour cette commande.');
            }

            return redirect()->route('commandesEffectif.afficherCommande');
        }



        public function choisirAutreHotel($numcommande)
        {
            // Récupérer les détails de la commande
            $commandeEffectif = CommandeEffectif::findOrFail($numcommande);
            
            // Logique pour récupérer les hôtels disponibles
            $hotelsDisponibles = DB::select("SELECT nom_partenaire
                                            FROM vinotrip_schema.commande_effectif ce
                                            JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                            JOIN vinotrip_schema.commande_sejour cs ON c.numcommande = cs.numcommande
                                            JOIN vinotrip_schema.sejour s ON s.refsejour = cs.refsejour
                                            JOIN vinotrip_schema.etape e ON e.refsejour = s.refsejour
                                            JOIN vinotrip_schema.etape_element_etape a ON e.id_etape = a.id_etape
                                            JOIN vinotrip_schema.element_etape aa ON a.idelement_etape = aa.idelement_etape
                                            JOIN vinotrip_schema.partenaire p ON p.id_partenaire = aa.id_partenaire
                                            WHERE ce.numcommande = 234");

            return view('commandesEffectif.choisirHotel', compact('commandeEffectif', 'hotelsDisponibles'));
        }


        public function envoyerAvisClient($numcommande, Request $request)
        {
            // Récupérer la commande
            $commandeEffectif = CommandeEffectif::findOrFail($numcommande);

            // Récupérer le mail du client
            $result = DB::select("SELECT cl.mailclient FROM vinotrip_schema.commande_effectif ce
                                JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                JOIN vinotrip_schema.client cl ON c.idclient = cl.idclient
                                WHERE ce.numcommande = " . $numcommande . " LIMIT 1")[0];

            if ($result) {
                $mailClient = $result->mailclient;

                // Récupérer l'hôtel choisi
                $hotelChoisi = $request->input('hotel');  // L'hôtel sélectionné par l'utilisateur
                
                // Envoi de l'email au client
                Mail::to($mailClient)->send(new DemandeAvisHotelMail($hotelChoisi));  // Assurez-vous d'avoir un Mailable 'DemandeAvisHotelMail'

                session()->flash('success', 'Un e-mail a été envoyé au client pour lui demander son avis sur l\'hôtel choisi.');

            } else {
                session()->flash('error', 'Aucun client trouvé pour cette commande.');
            }

            return redirect()->route('commandesEffectif.afficherCommande');
        }


        public function envoyerCarnetRoute($numcommande)
        {
            // Récupérer la commande
            $commandeEffectif = CommandeEffectif::findOrFail($numcommande);

            // Récupérer le mail du client
            $result = DB::select("SELECT cl.mailclient FROM vinotrip_schema.commande_effectif ce
                                JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                JOIN vinotrip_schema.client cl ON c.idclient = cl.idclient
                                WHERE ce.numcommande = " . $numcommande . " LIMIT 1")[0];

            if ($result) {
                $mailClient = $result->mailclient;

                $hotelChoisi = DB::select("SELECT nom_partenaire
                                            FROM vinotrip_schema.commande_effectif ce
                                            JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
											JOIN vinotrip_schema.client cc ON cc.idclient = c.idclient
                                            JOIN vinotrip_schema.commande_sejour cs ON c.numcommande = cs.numcommande
                                            JOIN vinotrip_schema.sejour s ON s.refsejour = cs.refsejour
                                            JOIN vinotrip_schema.etape e ON e.refsejour = s.refsejour
                                            JOIN vinotrip_schema.etape_element_etape a ON e.id_etape = a.id_etape
                                            JOIN vinotrip_schema.element_etape aa ON a.idelement_etape = aa.idelement_etape
                                            JOIN vinotrip_schema.partenaire p ON p.id_partenaire = aa.id_partenaire
											 JOIN vinotrip_schema.hotel h ON h.id_partenaire = p.id_partenaire
											where c.numcommande = " .$numcommande.
                                            " limit 1")[0]->nom_partenaire;

            
            
            $nomclient = $commandeEffectif->commande->client->nomclient;

            $destination = DB::select("SELECT nom_destination_sejour
                                            FROM vinotrip_schema.commande_effectif ce
                                            JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                            JOIN vinotrip_schema.commande_sejour cs ON c.numcommande = cs.numcommande
                                            JOIN vinotrip_schema.sejour s ON s.refsejour = cs.refsejour
											JOIN vinotrip_schema.destination_sejour d ON s.num_destination_sejour = d.num_destination_sejour
											where c.numcommande = " .$numcommande)[0]->nom_destination_sejour;

            

            Mail::to($mailClient)->send(new CarnetRouteMail($numcommande, $destination, $nomclient, $hotelChoisi));

            session()->flash('success', 'Un e-mail a été envoyé au client avec toute les informations du carnet de route.');

            } else {
                session()->flash('error', 'Aucun client trouvé pour cette commande.');
            }

            return redirect()->route('commandesEffectif.afficherCommande');
        }


        public function envoyerValidationPartenaire($numcommande)
        {
            $listeMailPartenaire = DB::select("SELECT distinct mailpartenaire
                                            FROM vinotrip_schema.commande_effectif ce
                                            JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
											JOIN vinotrip_schema.client cc ON cc.idclient = c.idclient
                                            JOIN vinotrip_schema.commande_sejour cs ON c.numcommande = cs.numcommande
                                            JOIN vinotrip_schema.sejour s ON s.refsejour = cs.refsejour
                                            JOIN vinotrip_schema.etape e ON e.refsejour = s.refsejour
                                            JOIN vinotrip_schema.etape_element_etape a ON e.id_etape = a.id_etape
                                            JOIN vinotrip_schema.element_etape aa ON a.idelement_etape = aa.idelement_etape
                                            JOIN vinotrip_schema.partenaire p ON p.id_partenaire = aa.id_partenaire
											where c.numcommande = ".$numcommande);

            $commandeEffectif = CommandeEffectif::findOrFail($numcommande);

            $idclient = $commandeEffectif->idclient;

            $client = client::findOrFail($idclient);

            $nomclient = $client->nomclient;

            $dateDebut = $commandeEffectif->date_debut_sejour;

            foreach ($listeMailPartenaire as $partenaire){
                Mail::to($partenaire->mailpartenaire)->send(new ValidationPartenaireMail($numcommande, $dateDebut, $nomclient));
            }
            session()->flash('success', 'Un e-mail a été envoyé au partenaire avec toute les informations du séjour');
            return redirect()->route('commandesEffectif.afficherCommande');
        }


        public function RembourserClient($numcommande)
        {
            $commandeEffectif = commandeEffectif::findOrFail($numcommande);

            $idclient = $commandeEffectif->idclient;

            $client = client::findOrFail($idclient);

            $mailclient = $client->mailclient;

            $prixsejourT = DB::select("SELECT distinct prix_sejour
                                            FROM vinotrip_schema.commande_effectif ce
                                            JOIN vinotrip_schema.commande c ON c.numcommande = ce.numcommande
                                            JOIN vinotrip_schema.commande_sejour cs ON c.numcommande = cs.numcommande
                                            JOIN vinotrip_schema.sejour s ON s.refsejour = cs.refsejour
                                            WHERE c.numcommande = " .$numcommande);

            $prixsejour = $prixsejourT[0]->prix_sejour;

            Mail::to($mailclient)->send(new RemboursementClientMail($prixsejour));

            session()->flash('success', 'Un e-mail a été envoyé au client avec les informations pour son remboursement.');
            return redirect()->route('commandesEffectif.afficherCommande');
        }

        
    

}