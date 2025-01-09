@extends('layouts.app')

@section('content')

    <div class="cave-detail-container">
        <h1>Domaine : {{ $partenaire->nom_partenaire }}</h1>
        <img src="{{ asset('img/img_partenaire/'.$partenaire['img_partenaire']) }}" alt="">

        <p><strong>Type de dégustation :</strong> {{ $cave->type_degustation->libelle_type_degustation }}</p>

        <!-- Informations générales -->
        <h3>Informations du Partenaire</h3>
        <p><strong>Téléphone :</strong> {{ $partenaire->tel_partenaire }}</p>
        <p><strong>Email :</strong> {{ $partenaire->mailpartenaire }}</p>
        <p><a href="{{ $partenaire->site_partenaire }}">Visiter le site</a></p>
    </div>
@endsection 