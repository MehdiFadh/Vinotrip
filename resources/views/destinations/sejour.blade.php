@extends('layouts.app')

@section('content')
  <div class="sejour-container">
        <h1>Séjours disponibles pour la destination : {{ $destination->nom_destination_sejour }}</h1>

        @if($destination->sejours->isEmpty())
            <p>Aucun séjour disponible pour cette destination.</p>
        @else
            <ul class="sejour-liste">
                @foreach($destination->sejours as $sejour)
                    <ul class="sejour-case">
                        <img src="{{ asset('img/img_sejour/'.$sejour['url_photo_sejour']) }}" alt="">
                        <h2 class="titreSejour">{{ $sejour->titresejour }}</h2>
                        <li class ="destination-sejour">{{$sejour->destination_sejour['nom_destination_sejour']}}</li>
                        <li class="description-sejour">Description : {{ $sejour->descriptionsejour }}</li>
                        <li class="prix-sejour">A partir de {{ $sejour->prix_sejour }} €</li>
                    <button class="buttonDecouvrirSejour" onclick="location.href='{{ route('sejour.showByRefSejour', ['refsejour' => $sejour->refsejour]) }}'">Découvrir l'offre</button>

                    </ul>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
