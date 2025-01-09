@extends('layouts.app')

@section('content')
<div class="container-details-commande">
    <h1 class="titre-commande-details">Détails de la commande : {{ $commande->numcommande }}</h1>
    <p class="info-commande-details">Date : {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</p>
    <p class="info-commande-details">Total : {{ $facture->montant_total }} €</p>

    <h3 class="sous-titre-commande-details">Détails de la commande</h3>

    <p><strong>Numéro de commande :</strong> {{ $commande->numcommande }}</p>
    <p><strong>Date de commande :</strong> {{ $commande->date_commande }}</p>
    <p><strong>Montant total de la facture :</strong> {{ isset($facture->montant_total) ? number_format($facture->montant_total, 2) : 'Non disponible' }} €</p>

    <div class="section-sous-details">
        <h4>Effectifs</h4>
        <table class="table-commande-details">
            <thead class="thead-commande-details">
                <tr>
                    <th>Nom</th>
                    <th>Nombre chambre</th>
                    <th>Nombre adultes</th>
                    <th>Date début</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($effectifs as $effectif)
                    <tr>
                        <td>{{ $effectif->nom ?? 'Non spécifié' }}</td>
                        <td>{{ $effectif->chambres ?? 0 }}</td>
                        <td>{{ $effectif->nb_adultes ?? 0 }}</td>
                        <td>{{ $effectif->date ?? 'Non spécifié' }}</td>
                    </tr>
                @empty
                    <tr class="ligne-aucune-donnee">
                        <td colspan="4">Aucun effectif trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section-sous-details">
        <h4>Cadeaux</h4>
        <table class="table-commande-details">
            <thead class="thead-commande-details">
                <tr>
                    <th>Nom</th>
                    <th>Nombre chambre</th>
                    <th>Nombre adultes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cadeaux as $cadeau)
                    <tr>
                        <td>{{ $cadeau->nom ?? 'Non spécifié' }}</td>
                        <td>{{ $cadeau->chambres ?? 0 }}</td>
                        <td>{{ $cadeau->nb_adultes ?? 0 }}</td>
                    </tr>
                @empty
                    <tr class="ligne-aucune-donnee">
                        <td colspan="3">Aucun cadeau trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
