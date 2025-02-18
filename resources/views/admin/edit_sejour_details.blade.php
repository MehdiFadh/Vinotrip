@extends('layouts.app')

@section('title', 'Modifier les Détails du Séjour')

@section('content')
<div class="container-detailed-sejour">
    <h1 class="header-sejour">Modifier les Détails du Séjour : {{ $sejour->titresejour }}</h1>

    <form action="{{ route('sejours.envoyerMailTousPartenaires') }}" method="GET">
        @csrf
        <button type="submit" class="btn-envoi-mail-partenaire">Mail disponibilité hôtel</button>
    </form>

    <form action="{{ route('sejours.details.complete.update', $sejour->refsejour) }}" method="POST" class="form-sejour-details">
        @csrf

        {{-- Type du Séjour --}}
        <div class="form-group-sejour">
            <label for="type_sejour" class="label-sejour">Type de Séjour</label>
            <select name="type_sejour" id="type_sejour" class="select-sejour" required>
                @foreach($categoriesSejours as $categorie)
                    <option value="{{ $categorie->idcategoriesejour }}" 
                        {{ $sejour->categorieSejours->pluck('idcategoriesejour')->contains($categorie->idcategoriesejour) ? 'selected' : '' }}>
                        {{ $categorie->type_sejour }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Destination --}}
        <div class="form-group-sejour">
            <label for="nom_destination_sejour" class="label-sejour">Destination</label>
            <select name="nom_destination_sejour" id="nom_destination_sejour" class="select-sejour" required>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->nom_destination_sejour }}" 
                        {{ $destination->num_destination_sejour == $sejour->destination_sejour->num_destination_sejour ? 'selected' : '' }}>
                        {{ $destination->nom_destination_sejour }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Route des Vins --}}
        <div class="form-group-sejour">
            <label for="nom_route_de_vins" class="label-sejour">Choisir une Route des Vins</label>
            <select name="nom_route_de_vins" id="nom_route_de_vins" class="select-sejour" required>
                @foreach($routes as $route)
                    <option value="{{ $route->nom_route_de_vins }}"
                        {{ $sejour->routesDeVins->pluck('num_route_de_vins')->contains($route->num_route_de_vins) ? 'selected' : '' }}>
                        {{ $route->nom_route_de_vins }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Type de Participant --}}
        <div class="form-group-sejour">
            <label for="type_participant" class="label-sejour">Choisir un Type de Participant</label>
            <select name="type_participant" id="type_participant" class="select-sejour" required>
                @foreach($categoriesParticipants as $categorie)
                    <option value="{{ $categorie->idcategorie_participant }} "
                        {{ $sejour->categorieParticipants->first() && $categorie->idcategorie_participant == $sejour->categorieParticipants->first()->idcategorie_participant ? 'selected' : '' }}>
                        {{ $categorie->type_participant }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-sejour-submit">Sauvegarder les Détails</button>
    </form>
</div>
@endsection
