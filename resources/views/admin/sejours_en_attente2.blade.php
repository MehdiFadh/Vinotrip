@extends('layouts.app')

@section('title', 'Séjours en Attente')

@section('content')
<div class="container-sejours-en-attente">
    <h1 class="header-sejours-attente">Séjours en Attente</h1>

    @if($sejoursEnAttente->isEmpty())
        <p class="message-no-sejours">Aucun séjour en attente de validation.</p>
    @else
        <table class="table-sejours-attente">
            <thead class="thead-sejours-attente">
                <tr>
                    <th class="th-sejour">Titre du Séjour</th>
                    <th class="th-sejour">Destination</th>
                    <th class="th-sejour">Prix (€)</th>
                    <th class="th-sejour">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sejoursEnAttente as $sejour)
                    <tr class="tr-sejour">
                        <td class="td-sejour">{{ $sejour->titresejour }}</td>
                        <td class="td-sejour">{{ $sejour->destination_sejour?->nom_destination_sejour ?? 'Non défini' }}</td>
                        <td class="td-sejour">{{ $sejour->prix_sejour ?? 'Non défini' }}</td>
                        <td class="td-sejour">
                            <a href="{{ route('sejours.details.complete.edit', $sejour->refsejour) }}" class="btn-sejour-primary">
                                Ajouter des détails
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
