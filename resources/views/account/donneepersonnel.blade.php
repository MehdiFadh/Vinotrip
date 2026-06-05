@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/donneepersonnel.css') }}">



@section('content')

@if(session('success'))
        <div class="alert-alert-success">
            {{ session('success') }}
        </div>
@endif

<div class="info-personnel">
<h1>Voici toutes les données personnelles que Vinotrip possède sur vous.</h1>

<h3>Nom : {{$client->nomclient}}</h3>
<h3>Prénom : {{$client->prenomclient}}</h3>
<h3>Email : {{$client->mailclient}}</h3>
<h3>Date de naissance : {{$client->datenaissance}}</h3>
<h3>Téléphone : {{$client->telclient}}</h3>

<h2>Adresse :</h2>
<h3>Rue : {{$adresseclient->rue_client}}</h3>
<h3>Code Postal : {{$adresseclient->code_postal_client}}</h3>
<h3>Ville : {{$adresseclient->ville_client}}</h3>
<h3>Pays : {{$adresseclient->pays_client}}</h3>
<h3>Latitude : {{$adresseclient->latitude}}</h3>
<h3>Longitude : {{$adresseclient->longitude}}</h3>

<h2>Données Bancaires :</h2>

@if ($referencebancaire == null)
    <p>Aucune donnée bancaire enregistrée</p>
@else
    <h3>Numéro de carte : {{$referencebancaire->numero_carte}}</h3>
    <h3>Date d'expiration : {{$referencebancaire->date_expiration}}</h3>
    <h3>CVC : {{$referencebancaire->cvc}}</h3>
    <h3>Nom sur la carte : {{$referencebancaire->nom_carte}}</h3>
@endif

<h2>Commandes : </h2>

    <div id="commandes">
        @foreach($commande as $index => $uneCommande)
            <div class="commande" id="commande-{{ $index }}">
                <h3>Numéro de commande : <a href="{{ route('commandes.details', $uneCommande->numcommande) }}">{{ $uneCommande->numcommande }}</a></h3>
                <h4>Date de commande : {{$uneCommande->date_commande}}</h4>
            </div>
        @endforeach
    </div>
</div>
<form action="{{ route('account.suppressionDonneePersonnel', $client->idclient) }}" method="GET">
    @csrf
    <button class="btn-account" type="submit">Demander la suppression de toutes mes données</button>
</form>

@endsection