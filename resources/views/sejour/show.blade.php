@extends('layouts.app')

@section('content')

<div class="sejour-detail-container">
    <h1>{{ $sejour->titresejour }}</h1>
    <img src="{{ asset('img/img_sejour/'.$sejour->url_photo_sejour) }}" alt="{{ $sejour->titresejour }}">
    <p class="descr"><strong>Description :</strong> {{ $sejour->descriptionsejour }}</p>

    <div class="etapes-container">
        @if(isset($etapes) && $etapes->count() > 0)
            <h3>Étapes de ce séjour :</h3>
            <ul>
                @foreach($etapes as $etape)
                    <li class="etape-item">

                        <!-- Titre et description de l'étape -->
                        <strong class="etape-title">{{ $etape->titre_etape . $etape->description_etape }}</strong>
                        <div class="etape-image-container">
                            <img class="img-etape" src="{{ asset('img/img_sejour/img_etape/' . $etape->url_photo_etape) }}" alt="Image de l'étape">
                        </div>

                        <!-- Vérification des partenaires associés -->
                        @if($etape->elementEtapes->count() > 0)
                            <ul class="partenaire-list">
                            @foreach($etape->elementEtapes->sortBy(fn($element) => $element->idelement_etape ?? '') as $element)
                                @if($element->partenaire)
                                    <li class="partenaire-item">
                                        <div class="partenaire-info">
                                            <!--<strong class="partenaire-name">{{ $element->partenaire->nom_partenaire }}</strong>-->
                                            <p class="partenaire-description">{{ $element->description }}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
            </ul>
        @else
        <p class="no-details">Pas plus de détails</p>
        @endif

                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune étape trouvée pour ce séjour.</p>
        @endif
    </div>

    <div class="hotels-container">
        @if($hotels && $hotels->count() > 0)
            <h3>Hébergements disponibles :</h3>
            <ul>
                @foreach($hotels as $hotel)
                    <li>
                        <strong>{{ $hotel->nom_partenaire }}</strong><br>
                        <img class="img-etape" src="{{ asset('img/img_partenaire/' . $hotel->img_partenaire) }}">

                        <button onclick="location.href='{{ route('hotel.details', [$hotel->id_partenaire]) }}'">
                            Voir les détails
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun hébergement disponible pour ce séjour.</p>
        @endif
    </div>

    <div class="hotels-container">
        @if($caves && $caves->count() > 0)
            <h3>Domaines disponibles :</h3>
            <ul>
                @foreach($caves as $cave)
                    <li>
                        <strong>{{ $cave->nom_partenaire }}</strong><br>
                        <img class="img-etape" src="{{ asset('img/img_partenaire/' . $cave->img_partenaire) }}">

                        <button onclick="location.href='{{ route('cave.details', [$cave->id_partenaire]) }}'">
                            Voir les détails
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun domaine disponible pour ce séjour.</p>
        @endif
    </div>

    <form action="{{ route('panier.ajouter.article') }}" method="POST" id="panier-form">
        @csrf
        <input type="hidden" name="sejour_id" value="{{ $sejour->refsejour }}">
        <input type="hidden" name="mode_cadeau" id="mode_cadeau" value="0">

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

        <button type="button" onclick="activerModeCadeau()">OFFRIR</button>
    </form>

    <script>
         function activerModeCadeau() {
            // Met la valeur du mode cadeau
            document.getElementById('mode_cadeau').value = 1;
            document.getElementById('panier-form').submit(); // Soumettre le formulaire
        }
    </script>

    <a id='reserver' href="{{ route('sejour.effectif.details', $sejour->refsejour) }}">
       RESERVER
    </a>
   

    <!-- Affichage des avis des clients -->
    <h2>Avis des clients :</h2>

    @if($sejour->avis->isEmpty())
        <p>Aucun avis pour ce séjour pour le moment.</p>
    @else
        <div class="avis-container" id="avis-container"> <!-- Nouvelle div pour les avis -->
            @foreach($sejour->avis as $avis)
                <div class="avis">
                    <p><strong>Note : {{ $avis['noteavis'] }} / 5</strong></p>
                    <p>{{ $avis->commentaire }}</p>
                    <p><em>Posté par : {{ $avis->client->nomclient }} {{ substr($avis->client->prenomclient, 0, 1) }}. le {{ $avis->dateavis->format('d/m/Y') }}</em></p>
                </div>
            @endforeach
        </div>
    @endif
</div>
<!-- 
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->
@endsection
