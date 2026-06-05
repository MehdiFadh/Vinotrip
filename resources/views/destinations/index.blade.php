@extends('layouts.app')
@section('content')
    <div class="container-destination">
        <h1 class="titre1">Toutes les destinations</h1>
        <div class="destinations-grid">
            @foreach($destinations as $destination)
                <div class="destination-card">
                    <h2 class="titre2">{{ $destination->nom_destination_sejour }}</h2>
                    <a class="lien" href="{{ route('destinations.sejours', $destination->num_destination_sejour) }}">Voir les séjours</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
