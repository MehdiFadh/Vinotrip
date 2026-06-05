@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/affichage.css') }}">


@section('content')
<div class="container">
@if(session('success'))
        <div class="alert-alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="text-center mb-4">HISTORIQUE DES COMMANDES</h1>
    <p class="text-center">Vous trouverez ici toutes les commandes passées par les clients.</p>

    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>RÉFÉRENCE DE COMMANDE</th>
                <th>DATE</th>
                <th>PAIEMENT</th>
                <th>ÉTAT</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($commandes as $commande)
                <tr>
                    <td>
                        <a href="{{ route('commandes.details', $commande->numcommande) }}">
                            {{ $commande->numcommande }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</td>
                 
                    
                    <td>Stripe</td> <!--A modifier une fois qu'on aura plusieurs moyens de paiement-->
                    <td>
                        <span class="badge {{ $commande->etat_commande ? 'badge-success' : 'badge-danger' }}">
                        @if ($commande->etat_commande == true)
                            Accepté
                        @else 
                            Attente
                        @endif
                        </span>
                    </td>

                    @if ($commande->etat_commande == false)
                    <td>
                        <form action="{{ route('commandesEffectif.envoyerMailDisponibilite', $commande->numcommande) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Mail vérification disponibilité hôtel</button>
                        </form>
                    </td>
                    
                    <td>
                        <form action="{{ route('commandesEffectif.envoyerReglementsejour', $commande->numcommande) }}" method="GET">
                        @csrf
                            <button type="submit" class="btn btn-primary">Mail règlement séjour</button>
                        </form>
                    </td>

                    <td>
                        
                            <form action="{{ route('commandesEffectif.choisirAutreHotel', $commande->numcommande) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-primary">Choisir un autre hôtel</button>
                            </form>
                        
                    </td>

                    <td>
                        <form action="{{ route('commandeEffectif.RembourserClient', $commande->numcommande) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Rembouser le client</button>
                        </form>
                    </td>

                    @endif

                    @if ($commande->etat_commande == true)
                    <td>
                        <form action="{{ route('commandesEffectif.envoyerCarnetRoute', $commande->numcommande) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Envoyer le carnet de route</button>
                        </form>
                    </td>

                    <td>
                        <form action="{{ route('commandesEffectif.envoyerValidationPartenaire', $commande->numcommande) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Mail validation partenaire</button>
                        </form>
                    </td>
                    @endif

                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucune commande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
