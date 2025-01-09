@extends('layouts.app')

@section('content')
<div class="container-inscription">
    <h2>Connexion</h2>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if(session('error'))
        <div class="alert-inscription">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="form-group-inscription">
            <label for="mailclient">Adresse e-mail</label>
            <input type="email" name="mailclient" id="mailclient" class="form-control" value="{{ old('mailclient') }}" required>
            @error('mailclient')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-inscription">
            <label for="mot_de_passe_client">Mot de passe</label>
            <input type="password" name="mot_de_passe_client" id="mot_de_passe_client" class="form-control" required>
            @error('mot_de_passe_client')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-inscription">Se connecter</button>
    </form>

    <div class="link-connexion">
        <p>Pas encore inscrit ? <a href="{{ route('inscription.index') }}">Créez un compte.</a></p>
    </div>
</div>
@endsection
