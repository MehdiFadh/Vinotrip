@extends('layouts.app')

@section('content')

<div class="sejour-detail-container">
    <h1>{{ $sejour->titresejour }}</h1>
    <img src="{{ asset('img/img_sejour/'.$sejour->url_photo_sejour) }}" alt="{{ $sejour->titresejour }}">
    <p class="descr"><strong>Description :</strong> {{ $sejour->descriptionsejour }}</p>

    <div class="etapes-container">
        <div class="hotels-container">
            @if(isset($hebergements) && count($hebergements) > 0)
                <h3>Hébergements :</h3>
                <ul>
                    @foreach($hebergements as $partenaire)
                        @if($partenaire->hotel)
                            <li>
                                <strong>{{ $partenaire->nom_partenaire }}</strong><br>
                                <button onclick="location.href='{{ route('hotel.details', [$partenaire->id_partenaire]) }}'">
                                    Voir les détails
                                </button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p>Aucun hébergement disponible pour ce séjour.</p>
            @endif
        </div>
    </div>

    <form id="panier-form" action="{{ route('panier.ajouter.cadeau') }}" method="POST">
        @csrf
        <input type="hidden" name="sejour_id" value="{{ $sejour->refsejour }}">
        <input type="hidden" id="mode_cadeau" name="mode_cadeau" value="0">

        <br><label for="date">Date du séjour :</label>
        <input type="date" name="date_sejour" id="date" min="{{date('d/m/Y')}}" value="{{date('Y-m-d')}}">

        <br><label for="adultes">Nombre d'adultes :</label>
        <input type="number" name="adultes" id="adultes" min="1" value="1">

        <br><label for="enfants">Nombre d'enfants :</label>
        <input type="number" name="enfants" id="enfants" min="0" value="0">

        <br><label for="chambres">Nombre de chambres :</label>
        <input type="number" name="chambres" id="chambres" min="1" value="1">

        <div class="container mt-5">
            <div class="tooltip-container">
                <i class="informations-supplémentaires">ℹ</i>
                <div class="tooltip">
                    Le nombre de personnes pour le séjour est limité à 10 (adultes + enfants). Merci de nous contacter pour des séjours avec plus de 10 personnes.
                </div>
            </div>
        </div>

        <!-- Section des options -->
        <div class="options-section">
            <h3>Sélectionnez vos options</h3>

            <table class="options-table">
                <tr>
                    <td>
                        <label>Dîner gastronomique :</label>
                        <div class="radio-group">
                            <label><input type="radio" name="diner_gastronomique" value="non" checked> Non</label>
                            <label><input type="radio" name="diner_gastronomique" value="oui"> Oui</label>
                        </div>
                    </td>
                    <td>
                        <label>Dîner :</label>
                        <div class="radio-group">
                            <label><input type="radio" name="diner" value="non" checked> Non</label>
                            <label><input type="radio" name="diner" value="oui"> Oui</label>
                        </div>
                    </td>
                    <td>
                        <label>Activités :</label>
                        <div class="radio-group">
                            <label>
                                <input type="radio" name="activite" value="activite1" checked >
                                Visite des vignobles
                            </label>

                            <label>
                                <input type="radio" name="activite" value="activite2" >
                                Fourchette et tire-bouchon en Côte de Nuits
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Prix total -->
        <div class="total-section">
            <strong>Prix Total :</strong> <span id="prix-total">{{$sejour->prix_sejour}} €</span>
        </div>

        <!-- Bouton de réservation -->
        <div class="reservation-button">
            <button type="submit" onclick="activerModeEffectif()">RÉSERVER</button>
        </div>
    </form>

    <script>
        const prixSejour = {{ $sejour->prix_sejour }}; // Prix de base du séjour
        const prixDinerGastronomique = 124; // Coût par personne
        const prixDiner = 20; // Coût par personne
        const prixVisite = 40; // Coût par personne
        

        const prixTotalElement = document.getElementById('prix-total');
        const adultesInput = document.getElementById('adultes');
        const enfantsInput = document.getElementById('enfants');
        const chambresInput = document.getElementById('chambres');
        const dinerGastronomiqueInput = document.querySelectorAll('input[name="diner_gastronomique"]');
        const dinerInput = document.querySelectorAll('input[name="diner"]');
        const activiteInput = document.querySelectorAll('input[name="activite"]');

        // Fonction pour mettre à jour le prix total
        function mettreAJourPrixTotal() {
            const adultes = parseInt(adultesInput.value) || 0;
            const enfants = parseInt(enfantsInput.value) || 0;
            const totalPersonnes = adultes + enfants;

            // Vérifie si les options sont sélectionnées
            const dinerGastronomique = document.querySelector('input[name="diner_gastronomique"]:checked').value === 'oui' ? prixDinerGastronomique : 0;
            const diner = document.querySelector('input[name="diner"]:checked').value === 'oui' ? prixDiner : 0;
            const activite = document.querySelector('input[name="activite"]:checked').value === 'activite1' ? prixVisite : 0;
           

            // Calculer le prix total
            const prixOptions = (dinerGastronomique + diner + activite) * totalPersonnes;
            const prixTotal = (prixSejour * totalPersonnes) + prixOptions;

            // Mettre à jour l'affichage
            prixTotalElement.textContent = prixTotal.toFixed(2) + ' €';
        }

        // Écouteurs d'événements pour les champs du formulaire
        adultesInput.addEventListener('input', mettreAJourPrixTotal);
        enfantsInput.addEventListener('input', mettreAJourPrixTotal);
        chambresInput.addEventListener('input', mettreAJourPrixTotal);

        // Ajouter des écouteurs pour les options
        dinerGastronomiqueInput.forEach(input => input.addEventListener('change', mettreAJourPrixTotal));
        dinerInput.forEach(input => input.addEventListener('change', mettreAJourPrixTotal));
        activiteInput.forEach(input => input.addEventListener('change', mettreAJourPrixTotal));

        // Validation de la date
        document.getElementById('date').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Ignore l'heure

            if (selectedDate < today) {
                alert("Veuillez sélectionner une date future.");
                this.value = ''; // Réinitialise la valeur
            }
        });

        function activerModeEffectif() {
            document.getElementById('mode_cadeau').value = 0; // Désactiver le mode cadeau
        }
        public function ajouterAuPanier(Request $request)
        {
            $adultes = $request->input('adultes');
            $enfants = $request->input('enfants');
            $chambres = $request->input('chambres');
            $totalPersonnes = $adultes + $enfants;

            if ($adultes + $enfants > 2 && $chambres==1) {
                return redirect()->back()->with('error', 'Le nombre de personne ne peut pas dépasser la capacité des chambres.');
            }


            if ($totalPersonnes > 8) {
                return redirect()->back()->with('error', 'Le nombre total de personnes (adultes + enfants) ne peut pas dépasser 8.');
            }

            if ($totalPersonnes > $chambres * 2) {
                return redirect()->back()->with('error', 'Le nombre total de personnes ne peut pas dépasser 2 par chambre.');
            }

            
        }

    </script>
@endsection
