@extends('layouts.app')

@section('content')

<script>
    function normalizeText(text) {
        // Supprime les accents et met tout en minuscules
        return text
            .normalize("NFD") // Décompose les caractères accentués en caractères simples + diacritiques
            .replace(/[\u0300-\u036f]/g, "") // Supprime les diacritiques
            .toLowerCase(); // Met tout en minuscules
    }

    function filterSejours() {
    var searchQuery = normalizeText(document.getElementById('searchBar').value); // Recherche normalisée
    var destinationFilter = normalizeText(document.getElementById('destinationSelect').value); // Destination filtrée
    var participantFilter = normalizeText(document.getElementById('participantSelect').value); // Catégorie de participant filtrée
    var categorieFilter = normalizeText(document.getElementById('categorieSejourSelect').value); // Catégorie de séjour filtrée

    var sejours = document.querySelectorAll('.sejour-case'); // Toutes les cases de séjour
    var hasVisibleSejour = false; // Variable pour suivre s'il y a au moins un séjour visible

    sejours.forEach(function (sejour) {
        // Récupération des champs pour chaque séjour
        var titreSejour = normalizeText(sejour.querySelector('.titreSejour').textContent);
        var destinationSejour = normalizeText(sejour.querySelector('.destination-sejour').textContent);
        var participants = normalizeText(sejour.querySelector('.categorie-participant').textContent);

        // Vérification de correspondance avec les catégories
        var matchesCategorie = categorieFilter === 'all' || 
            sejour.classList.contains('categorie-' + categorieFilter.replace(/\s+/g, '-'));

        // Recherche approximative (par inclusion et tolérance aux erreurs)
        var matchesSearch =
            titreSejour.includes(searchQuery) || 
            destinationSejour.includes(searchQuery) || 
            participants.includes(searchQuery);

        var matchesDestination = destinationFilter === 'all' || destinationSejour.includes(destinationFilter);
        var matchesParticipants = participantFilter === 'all' || participants.includes(participantFilter);

        // Si le séjour correspond, on l'affiche
        if (matchesSearch && matchesDestination && matchesParticipants && matchesCategorie) {
            sejour.style.display = 'block'; // Afficher le séjour
            hasVisibleSejour = true; // Au moins un séjour est visible
        } else {
            sejour.style.display = 'none'; // Masquer le séjour
        }
    });

    // Affiche le message si aucun séjour n'est visible
    var noResultsMessage = document.getElementById('noResultsMessage');
    if (hasVisibleSejour) {
        noResultsMessage.style.display = 'none'; // Cacher le message
    } else {
        noResultsMessage.style.display = 'block'; // Afficher le message
    }
}

</script>

    <div class="filters-container-sejour">
        <div class="container mt-5">
            <div class="tooltip-container">
                <i class="informations-supplémentaires">ℹ</i>
                <div class="tooltip">
                    Merci de valider votre recherche avec le bouton "Rechercher" à droite 
                </div>
            </div>
        </div>
        <form action="#" method="GET">
            <div class="search-bar-container">
                <label for="searchBar"></label>
                <input type="text" id="searchBar" placeholder="Entrez un critère de recherche">
                <!-- Bouton de recherche -->
                
            </div>
        </form>

        <!-- Autres filtres -->
        <select class="btnDestination-sejour" id="destinationSelect" onchange="filterSejours()">
            <option value="all" {{ isset($selectedDestination) && $selectedDestination == 'all' ? 'selected' : '' }}>Toutes les destinations</option>
            @foreach($destinations as $destination)
                <option value="{{ $destination->nom_destination_sejour }}" 
                    {{ isset($selectedDestination) && $selectedDestination == $destination->nom_destination_sejour ? 'selected' : '' }}>
                    {{ $destination->nom_destination_sejour }}
                </option>
            @endforeach
        </select>


        <select class="btnParticipant-sejour" id="participantSelect" onchange="filterSejours()">
            <option value="all">Pour qui ?</option>
            @foreach($categorie_participant as $categorie)
                <option value="{{$categorie->type_participant}}">{{$categorie->type_participant}}</option>
            @endforeach
        </select>

        <select class="btnCategorie-sejour" id="categorieSejourSelect" onchange="filterSejours()">
            <option value="all">Toutes les catégories</option>
            @foreach($categorie_sejour as $categorie)
                <option value="{{$categorie->type_sejour}}">{{$categorie->type_sejour}}</option>
            @endforeach
        </select>

        <button type="button" class="btnRechercher-sejour" id="searchButton" onclick="filterSejours()">Rechercher</button>
    </div>

    <div class="sejour-container-sejour">
        <ul class="sejour-liste-sejour">
            @foreach($sejours as $sejour)
            <li class="sejour-case 
                {{$sejour->destination_sejour['nom_destination_sejour']}} 
                @foreach($sejour->categorieParticipants ?? [] as $categorieParticipant)
                    {{$categorieParticipant->type_participant}} 
                @endforeach 
                @foreach($sejour->categorieSejours ?? [] as $categorieSejour)
                    categorie-{{ strtolower(str_replace(' ', '-', $categorieSejour->type_sejour)) }} <!-- Remplace les espaces par des tirets et met tout en minuscules -->
                @endforeach">

                <img src="{{ asset('img/img_sejour/'.$sejour['url_photo_sejour']) }}" alt="">
                <h2 class="titreSejour">{{$sejour['titresejour']}}</h2>
                <ul class="descriptionSejour">
                    <li class="destination-sejour">{{$sejour->destination_sejour['nom_destination_sejour']}}</li>
                    <li class="description-sejour">{{$sejour['descriptionsejour']}}</li>
                    <li class="categorie-participant">
                        <strong>Participants :</strong>
                        @foreach($sejour->categorieParticipants ?? [] as $categorieParticipant)
                            {{$categorieParticipant->type_participant}}
                        @endforeach
                    </li>
                    <li class="categorie-sejour">
                        <strong>Catégories de séjour :</strong>
                        @foreach($sejour->categorieSejours ?? [] as $categorieSejour)
                            {{$categorieSejour->type_sejour}}
                        @endforeach
                    </li>
                    <li class="prix-sejour">À partir de {{$sejour['prix_sejour']}} €</li>
                    <div class="container mt-5">
                        <div class="tooltip-container">
                            <i class="informations-supplémentaires">ℹ</i>
                            <div class="tooltip">
                                Le prix varie selon le nombre de personnes pour le séjour
                            </div>
                        </div>
                    </div>
                    <li class="avis-sejour">                    
                        @if($sejour['moyenne_avis'] == 0)                                
                        <p>Il n'y a pas encore d'avis.</p>
                        @else
                            <div class="etoiles">
                                @php
                                    $moyenne_avis = $sejour['moyenne_avis'];
                                    $etoiles_pleines = floor($moyenne_avis);
                                    $etoiles_vides = 5 - $etoiles_pleines;
                                @endphp
                                @for($i = 0; $i < $etoiles_pleines; $i++)
                                    <span class="star filled">★</span>
                                @endfor
                                @for($i = 0; $i < $etoiles_vides; $i++)
                                    <span class="star empty">☆</span>
                                @endfor
                            </div>
                            
                            <p>Moyenne des avis : {{ $moyenne_avis }} / 5
                            <button class="lien-avis" 
                                    onclick="location.href='{{ route('sejour.showByRefSejour', ['refsejour' => $sejour->refsejour]) }}#avis-container'">
                                Lire les avis
                            </button>
                            </p>
                        @endif
                    </li>
                    <li class="nombre-etapes">
                        {{-- Afficher le nombre de jours avec gestion du pluriel --}}
                        {{ $sejour->etapes_count }} 
                        <strong>jour{{ $sejour->etapes_count > 1 ? 's' : '' }}</strong>
                        
                        {{-- Calculer le nombre de nuits --}}
                        @php
                            $nbnuits = max(0, $sejour->etapes_count - 1);
                        @endphp

                        {{-- Afficher le nombre de nuits avec gestion du pluriel --}}
                        | {{ $nbnuits }} 
                        <strong>nuit{{ $nbnuits > 1 ? 's' : '' }}</strong>
                    </li>
                </ul>
                <button class="buttonDecouvrirSejour" 
                        onclick="location.href='{{ route('sejour.showByRefSejour', ['refsejour' => $sejour->refsejour]) }}'">
                    Découvrir l'offre
                </button>
            </li>
            @endforeach
        </ul>
        <div id="noResultsMessage" style="display: none; text-align: center; color: red; font-weight: bold;">
            Aucun séjour ne correspond à votre recherche.
        </div>

    </div>

    

    <script>
        // Script exécuté au chargement de la page
        document.addEventListener("DOMContentLoaded", function () {
            // Vérifiez si une destination est pré-sélectionnée
            const destinationSelect = document.getElementById('destinationSelect');
            const selectedValue = destinationSelect.value;

            // Si une destination autre que "all" est sélectionnée, exécuter filterSejours()
            if (selectedValue !== 'all') {
                filterSejours();
            }
        });

    </script>
@endsection