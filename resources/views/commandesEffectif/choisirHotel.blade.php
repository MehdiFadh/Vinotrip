@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/choisirHotel.css') }}">

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Choisir un autre hôtel</h1>
    <p class="text-center">Choisissez un hôtel disponible pour la commande n° {{ $commandeEffectif->numcommande }}.</p>

    <form action="{{ route('commandesEffectif.envoyerAvisClient', $commandeEffectif->numcommande) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="hotel">Choisir un hôtel :</label>
            <select name="hotel" id="hotel" class="form-control" required>
                @foreach($hotelsDisponibles as $hotel)
                    <option >{{ $hotel->nom_partenaire }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer la demande d'avis au client</button>
    </form>
</div>
@endsection