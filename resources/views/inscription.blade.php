    @extends('layouts.app')

    @section('content')
    <div class="container-inscription">
        <h2>Inscription</h2>

        <!-- Affichage des messages de succès -->
        @if(session('success'))
            <div class="alert-inscription success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Affichage des messages d'erreur -->
        @if($errors->any())
            <div class="alert-inscription error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire d'inscription -->
        <form method="POST" action="{{ route('inscription.store') }}">
            @csrf

            <div class="form-group-inscription">
                <label for="nomclient">Nom</label>
                <input type="text" name="nomclient" id="nomclient" class="form-control" value="{{ old('nomclient') }}" required>
            </div>

            <div class="form-group-inscription">
                <label for="prenomclient">Prénom</label>
                <input type="text" name="prenomclient" id="prenomclient" class="form-control" value="{{ old('prenomclient') }}" required>
            </div>

            <div class="form-group-inscription">
                <label for="mailclient">Adresse e-mail</label>
                <input type="email" name="mailclient" id="mailclient" class="form-control" value="{{ old('mailclient') }}" required>
            </div>

            <div class="form-group-inscription">
                <label for="datenaissance">Date de naissance</label>
                <input type="date" name="datenaissance" id="datenaissance" class="form-control" value="{{ old('datenaissance') }}" required>
            </div>

            <div class="form-group-inscription">
                <label for="telclient">Numéro de téléphone</label>
                <input type="text" name="telclient" id="telclient" class="form-control" value="{{ old('telclient') }}" required>
            </div>

            <div class="form-group-inscription">
                <label for="mot_de_passe_client">Mot de passe</label>
                <input type="password" name="mot_de_passe_client" id="mot_de_passe_client" class="form-control" required>
            </div>

            <div class="form-group-inscription">
                <label for="mot_de_passe_client_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="mot_de_passe_client_confirmation" id="mot_de_passe_client_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-inscription">S'inscrire</button>
        </form>
        <div class="link-connexion">
            <p>Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous ici</a></p>
        </div>
    </div>

    <!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->
    @endsection
