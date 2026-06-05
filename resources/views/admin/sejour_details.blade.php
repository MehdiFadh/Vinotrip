@extends('layouts.app')

@section('title', 'Détails du Séjour')

@section('content')
<div class="container-sejour-details">
    <h1 class="header-sejour-details">Détails du Séjour : {{ $sejour->titresejour }}</h1>

    <div class="details-sejour">
        {{-- Type du Séjour --}}
        <div class="details-item-sejour">
            <label class="label-sejour-details">Type de Séjour</label>
            <p class="value-sejour-details">
                {{ $sejour->categorieSejours->pluck('type_sejour')->first() ?? 'Non défini' }}
            </p>
        </div>

        {{-- Destination --}}
        <div class="details-item-sejour">
            <label class="label-sejour-details">Destination</label>
            <p class="value-sejour-details">
                {{ $sejour->destination_sejour->nom_destination_sejour ?? 'Non défini' }}
            </p>
        </div>

        {{-- Route des Vins --}}
        <div class="details-item-sejour">
            <label class="label-sejour-details">Route des Vins</label>
            <p class="value-sejour-details">
                {{ $sejour->routesDeVins->pluck('nom_route_de_vins')->first() ?? 'Non défini' }}
            </p>
        </div>

        {{-- Type de Participant --}}
        <div class="details-item-sejour">
            <label class="label-sejour-details">Type de Participant</label>
            <p class="value-sejour-details">
                {{ $sejour->categorieParticipants->pluck('type_participant')->first() ?? 'Non défini' }}
            </p>
        </div>
    </div>
</div>
@endsection

