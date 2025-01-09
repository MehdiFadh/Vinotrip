@extends('layouts.app')

@section('content')
<div class="container-account">
    <h2>Mon Compte</h2>

    <!-- Affichage des messages de succès -->
    @if(session('success'))
        <div class="alert-account">
            {{ session('success') }}
        </div>
    @endif

    <div class="details-account">
        <!-- Formulaire pour mettre à jour les informations utilisateur -->
        <form action="{{ route('account.update') }}" method="POST">
            @csrf
            @method('PUT') <!-- Utiliser PUT pour une mise à jour -->

            <div class="form-group-account">
                <label for="nomclient">Nom</label>
                <input type="text" id="nomclient" name="nomclient" class="form-control" value="{{ old('nomclient', $user->nomclient) }}" required>
                @error('nomclient')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-account">
                <label for="prenomclient">Prénom</label>
                <input type="text" id="prenomclient" name="prenomclient" class="form-control" value="{{ old('prenomclient', $user->prenomclient) }}" required>
                @error('prenomclient')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-account">
                <label for="mailclient">Email</label>
                <input type="email" id="mailclient" name="mailclient" class="form-control" value="{{ old('mailclient', $user->mailclient) }}" required>
                @error('mailclient')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-account">
                <label for="datenaissance">Date de naissance</label>
                <input type="date" id="datenaissance" name="datenaissance" class="form-control" value="{{ old('datenaissance', $user->datenaissance ? \Carbon\Carbon::parse($user->datenaissance)->format('Y-m-d') : '') }}" required>
                @error('datenaissance')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-account">
                <label for="telclient">Téléphone</label>
                <input type="text" id="telclient" name="telclient" class="form-control" value="{{ old('telclient', $user->telclient) }}" required>
                @error('telclient')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-account">Sauvegarder les modifications</button>
        </form>
    </div>

    <div class="account-orders">
        <h3 class="account-orders-title">Mes Bons cadeaux
        </h3>

        <!-- Commandes Cadeaux -->
        <div class="orders-section">
            @if($commandesCadeaux->isEmpty())
                <p class="orders-section-empty">Aucune commande cadeau trouvée.</p>
            @else
                <ul class="orders-section-list">
                    @foreach($commandesCadeaux as $commande)
                        <li class="orders-section-item">
                            <strong class="orders-section-item-title">Commande #{{ $commande->numcommande }}</strong>

                            @if(isset($commande->date_commande))
                                <span class="orders-section-item-date">- {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</span>
                            @else
                                <span class="orders-section-item-date">- Date non spécifiée</span>
                            @endif
                            <p class="orders-section-item-gift-code">Code cadeau : {{ $commande->code_cadeau }}</p>
                            <div class="container mt-5">
                                <div class="tooltip-container">
                                    <i class="informations-supplémentaires">ℹ</i>
                                    <div class="tooltip">
                                    Voici le bon cadeau que vous devez garder secret et remettre à son bénéficiaire.
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
