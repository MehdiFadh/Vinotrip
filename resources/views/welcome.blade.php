@extends('layouts.app')

@section('content')

@cookieconsentview

    
    @if(session('success'))
        <div class="alert-paiement-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert-paiement-erreur">
            {{ session('error') }}
        </div>
    @endif


    <video autoplay loop muted>
        <source src="{{ asset('video/home_video.mp4') }}" type="video/mp4">
        Votre navigateur ne supporte pas la lecture de vidéos.
    </video>
    <div class="some-sejours">
        
    <button class="sejBut" onclick="location.href='/sejours';">Tous nos séjours</button>
    </div>
    <div class="welcome-avis">
        <h1>Avis des voyageurs </h1>

        <ul class="liste-avis">
            @foreach($avis->take(4) as $avie)
                <li>
                    <h2 class="titreAvis">{{ $avie->sejour->titresejour }} <span class="noteAvis">{{$avie['noteavis']}}/5</span>
                    <button class="butAvis" onclick="location.href='{{ route('sejour.showByTitre', ['titresejour' => $avie->sejour->titresejour]) }}'">Voir le séjour et ses avis</button></h2>
                </li>
                <li class="commAvis">{{$avie['commentaire']}} <span class="nomClient">{{$avie->client->nomclient}}</span> <span class="prenomClient">{{substr($avie->client->prenomclient, 0, 1)}}.</span></li>
            @endforeach
        </ul>
    </div>

    

    <!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script> -->
    <!-- <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->


@endsection