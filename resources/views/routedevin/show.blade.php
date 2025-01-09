@extends('layouts.app')

@section('content')

    <a href="/route_de_vins">Retour</a>
    <div class="route_de_vins-details">
        <h1>{{ $route_de_vins->nom_route_de_vins}}</h1>
        <p>{{ $route_de_vins->description_route_de_vins}}</p>
        <div>
            <h2>Découvrez la <span>{{ $route_de_vins->nom_route_de_vins}}</span> à travers ces vignobles </h2>
            <ul>
            @foreach($caves as $cave)
                <li class="vignobles">{{$cave->nom_partenaire}}</li>
            @endforeach
            </ul>
        </div>
        <h2>Séjours correspondants :</h2>
        @if($sejours == null){
            <p>Aucun sejour correspondants</p>
        }
        @endif
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
                    <li class="sejour-item">
                        <div class="sejour-info">
                            <h2>{{ $sejour->nom }}</h2>
                            <p>{{ $sejour->nombre_jours }} jour{{ $sejour->nombre_jours > 1 ? 's' : '' }}</p>
                        </div>
                    </li>
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
                            
                            <p>Moyenne des avis : {{ $moyenne_avis }} / 5</p>
                        @endif
                    </li>
                </ul>
                <button class="buttonDecouvrirSejour" 
                        onclick="location.href='{{ route('sejour.showByRefSejour', ['refsejour' => $sejour->refsejour]) }}'">
                    Découvrir l'offre
                </button>
            </li>
            @endforeach
        </ul>
    </div>
@endsection