@extends('layouts.app')

@section('content')
<div class="container-commande-historique">
    <h1 class="titre-commande-historique text-center mb-4">HISTORIQUE DE VOS COMMANDES</h1>
    <p class="description-commande-historique text-center">
        Vous trouverez ici vos commandes passées depuis la création de votre compte.
    </p>

    <table class="tableau-commande-historique table table-bordered text-center">
        <thead class="en-tete-tableau-commande">
            <tr>
                <th>RÉFÉRENCE DE COMMANDE</th>
                <th>DATE</th>
                <th>PRIX TOTAL</th>
                <th>PAIEMENT</th>
                <th>ÉTAT</th>
                <th>FACTURE</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($commandes as $commande)
                <tr>
                    <td>
                        <a href="{{ route('commandes.details', $commande->numcommande) }}" class="lien-details-commande">
                            {{ $commande->numcommande }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</td>
                    <td>{{ $commande->montant_total }} €</td>
                    <td>Stripe</td>
                    <td>
                        @if (is_null($commande->etat_commande))
                        <form action="{{ route('checkout.session') }}" method="POST">
                            @csrf
                            <!-- Champ caché pour transmettre le numéro de commande -->
                            <input type="hidden" name="numcommande" value="{{ $commande->numcommande }}">
                            <button type="submit">Procéder au paiement</button>
                        </form>
                        @elseif ($commande->etat_commande)
                            <span class="badge badge-commande-acceptee">Paiement accepté</span>
                        @else
                            <span class="badge badge-commande-en-attente">Commande annulée</span>
                        @endif
                    </td>
                    <td>
                        @if ($commande->facture_pdf)
                            <a href="{{ asset('storage/' . $commande->facture_pdf) }}" class="bouton-facture-pdf" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        @else
                            
                            <div class="container mt-5">
                                <span class="texte-commande-sans-facture">Pas de facture</span>
                                <div class="tooltip-container">
                                    <i class="informations-supplémentaires">ℹ</i>
                                    <div class="tooltip">
                                        La facture n'est pas disponible. Merci de nous contacter pour tout renseignement.                                    
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
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
