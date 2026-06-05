@extends('layouts.app')

@section('content')

    <div class="hotel-detail-container">
        <h1>{{ $partenaire->nom_partenaire }}</h1>
        <img src="{{ asset('img/img_partenaire/'.$partenaire['img_partenaire']) }}" alt="">
        <p><strong>Catégorie :</strong> {{ $hotel->categorie_ }}</p>
        <p><strong>Nombre de chambres :</strong> {{ $hotel->nb_chambres }}</p>

        <!-- Affichage des informations du partenaire -->
        <h3>Informations du partenaire</h3>
        <p><strong>Téléphone :</strong> {{ $partenaire->tel_partenaire }}</p>
        <p><strong>Email :</strong> {{ $partenaire->mailpartenaire }}</p>
        <p><a href="{{ $partenaire->site_partenaire }}">Visiter le site</a></p>
    </div>
@endsection