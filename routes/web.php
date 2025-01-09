<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SejourController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\RouteDeVinController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandeEffectifController;
use App\Http\Controllers\ConditionsUtilisationController;
use App\Http\Controllers\PolitiqueDeConfidentialiteController;
use App\Http\Controllers\MentionsLegalesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConditionsVenteController;
use App\Http\Controllers\CategorieParticipantController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CaveController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VenteController;
use App\Models\Sejour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BotManController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Déconnexion
Route::post('/logout', function () {Auth::logout();return redirect('/');})->name('logout');
Route::get('/inscription', [InscriptionController::class, 'index'])->name('inscription.index');
Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');

Route::get('/sejours', [SejourController::class, 'index']);
Route::get('/categories', [CategorieParticipantController::class, 'index']);
Route::get('/destinationss', [DestinationController::class, 'showDestination']);
Route::get('/commandes', [CommandeController::class, 'index']);
Route::get('/avis', [AvisController::class, 'index']);
Route::get('/client', [ClientController::class, 'index']);
Route::get('/etape', [EtapeController::class, 'index']);
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{id}/sejours', [DestinationController::class, 'showSejours'])->name('destinations.sejours');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');

Route::get('/', [AvisController::class, 'index'])->name('home');

Route::get('/conditions_vente', [ConditionsVenteController::class, 'index']);
Route::get('/conditions_utilisation', [ConditionsUtilisationController::class, 'index']);
Route::get('/politique_de_confidentialite', [PolitiqueDeConfidentialiteController::class, 'index']);
Route::get('/mentions_legales', [MentionsLegalesController::class, 'index']);
Route::get('/nous_contacter', [ContactController::class, 'index']);


Route::get('/route_de_vins', [RouteDeVinController::class, 'index']);
Route::get('/route_de_vins/{num_route_de_vins}', [RouteDeVinController::class, 'showByNumRoute'])->name('route_de_vins.showByNumRoute');

Route::get('/avie/sejour/{titresejour}', [SejourController::class, 'showByTitre'])->name('sejour.showByTitre');
Route::get('/sejour/sejour/{refsejour}', [SejourController::class, 'showByRefSejour'])->name('sejour.showByRefSejour');
Route::get('/sejours/{num_destination_sejour}', [DestinationController::class, 'showSejourss'])->name('destinations.sejours');

Route::get('/hotel/{id_partenaire}', [HotelController::class, 'show'])->name('hotel.details');
Route::get('/cave/{id_partenaire}', [CaveController::class, 'show'])->name('cave.details');


Route::get('/panier', [PanierController::class, 'afficher'])->name('panier.afficher');

Route::post('/panier/ajouterSejourEffectif', [PanierController::class, 'ajouterSejourEffectif'])->name('panier.ajouterSejourEffectif');
Route::post('/panier/ajouter-cadeau', [PanierController::class, 'ajouterCadeau'])->name('panier.ajouter.cadeau');
Route::post('/panier/modifier', [PanierController::class, 'modifier'])->name('panier.modifier');
Route::post('/panier/supprimer', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::post('/panier/ajouter-message-commande', [PanierController::class, 'ajouterMessageCommande'])->name('panier.ajouterMessageCommande');
Route::post('/panier/ajouter-code-reduction', [PanierController::class, 'ajouterCodeCadeau'])->name('panier.CodeReduction');

Route::middleware('auth')->group(function () {
    Route::get('/mon-compte', [AccountController::class, 'show'])->name('account.show'); // Afficher le compte
    Route::put('/mon-compte', [AccountController::class, 'update'])->name('account.update'); // Mettre à jour le compte
});

Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login'])->name('login.submit');

Route::get('/verification', [VerificationController::class, 'show'])->name('verification.notice');
Route::post('/verification', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/sejour/effectif/reservation', [SejourController::class, 'reserverEffectif'])->name('sejour.effectif.reservation');
Route::get('/sejour/effectif/{id}', [SejourController::class, 'showEffectifDetails'])->name('sejour.effectif.details');


Route::get('/paiement/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/commande/preparation', [PaymentController::class, 'preparation'])->name('commande.preparation');
Route::get('/paiement/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/booking/save', [PaymentController::class, 'save'])->name('enregistrement.commande');
Route::post('/checkout/session', [PaymentController::class, 'createCheckoutSession'])->name('checkout.session');


Route::get('/historique-commandes', [CommandeController::class, 'historique'])->name('commandes.historique');
Route::get('/commandesEffectif-affichage', [CommandeEffectifController::class, 'afficherCommande'])->name('commandesEffectif.afficherCommande');
Route::get('/commandesEffectif-disponibilite/{commande}', [CommandeEffectifController::class, 'envoyerMailDisponibilite'])->name('commandesEffectif.envoyerMailDisponibilite');
Route::get('/commandesEffectif-reglement/{commande}', [CommandeEffectifController::class, 'envoyerReglementsejour'])->name('commandesEffectif.envoyerReglementsejour');
Route::get('/commandesEffectif-validation-partenaire/{commande}', [CommandeEffectifController::class, 'envoyerValidationPartenaire'])->name('commandesEffectif.envoyerValidationPartenaire');

Route::get('/commandesEffectif/choisirHotel/{commande}', [CommandeEffectifController::class, 'choisirAutreHotel'])->name('commandesEffectif.choisirAutreHotel');
Route::post('/commandesEffectif/envoyerAvisClient/{commande}', [CommandeEffectifController::class, 'envoyerAvisClient'])->name('commandesEffectif.envoyerAvisClient');
Route::post('/commandesEffectif/carnetRoute/{commande}', [CommandeEffectifController::class, 'envoyerCarnetRoute'])->name('commandesEffectif.envoyerCarnetRoute');

Route::post('/commandeEffectif/{commande}/remboursement', [CommandeEffectifController::class, 'RembourserClient'])->name('commandeEffectif.RembourserClient');
Route::get('/commandes/{numcommande}/details', [CommandeController::class, 'details'])->name('commandes.details');
Route::get('/commandes/{numcommande}/facture', [CommandeController::class, 'facture'])->name('commandes.facture');
Route::get('/commande/adresse', [CommandeController::class, 'choisirAdresse'])->name('commande.adresse');
Route::post('/commande/adresse', [CommandeController::class, 'enregistrerAdresse']);


Route::post('/commande/{numcommande}/mail-reglement', [CommandeEffectifController::class, 'envoyerMailReglement'])->name('commande.mailReglement');


Route::post('/panier/code-reduction', [PanierController::class, 'appliquerCodeReduction'])->name('panier.CodeReduction');

Route::get('/nouveau', [SejourController::class, 'create'])->name('sejours.create');

Route::post('/nouveau', [SejourController::class, 'store'])->name('sejours.store');
Route::get('/admin/sejours/validation', [SejourController::class, 'showSejoursEnAttente'])->name('sejours.validation');
Route::patch('/sejours/{refsejour}/valider', [SejourController::class, 'validerSejour'])->name('sejours.valider');
Route::patch('/sejours/{refsejour}/refuser', [SejourController::class, 'refuserSejour'])->name('sejours.refuser');


// Routes pour validation ou refus des séjours
Route::patch('/sejours/{sejour}/valider', [SejourController::class, 'valider'])->name('sejours.valider');
Route::patch('/sejours/{sejour}/refuser', [SejourController::class, 'refuser'])->name('sejours.refuser');



Route::get('/ventes/commandes', [VenteController::class, 'listeCommandes'])->name('ventes.commandes');
Route::post('/ventes/envoyer-email', [VenteController::class, 'envoyerEmail'])->name('ventes.envoyerEmail');



Route::match(['get', 'post'], '/botman', 'App\Http\Controllers\BotManController@handle');