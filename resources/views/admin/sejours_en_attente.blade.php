@extends('layouts.app')

@section('title', 'Séjours en Attente de Validation')

@section('content')
<div class="container-sejours-validation">
    <h1 class="header-sejours-validation">Séjours en Attente de Validation</h1>

    @if($sejoursEnAttente->isEmpty())
        <p class="message-no-sejours">Aucun séjour en attente de validation.</p>
    @else
        <table class="table-sejours-validation">
            <thead class="thead-sejours-validation">
                <tr>
                    <th class="th-sejour">Titre du Séjour</th>
                    <th class="th-sejour">Destination</th>
                    <th class="th-sejour">Prix (€)</th>
                    <th class="th-sejour">Expiré le</th>
                    <th class="th-sejour">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sejoursEnAttente as $sejour)
                    <tr class="tr-sejour">
                        <td class="td-sejour">{{ $sejour->titresejour }}</td>
                        <td class="td-sejour">{{ $sejour->destination_sejour->nom_destination_sejour }}</td>
                        <td class="td-sejour">{{ $sejour->prix_sejour }}</td>
                        <td class="td-sejour">
                            @if($sejour->date_en_attente)
                                {{ $sejour->date_en_attente->format('d/m/Y H:i') }}
                            @else
                                <em>Aucune date d'attente</em>
                            @endif
                        </td>
                        <td class="td-sejour">
                            <form action="{{ route('sejours.valider', $sejour->refsejour) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-sejour-validate">Valider</button>
                            </form>
                            <form action="{{ route('sejours.refuser', $sejour->refsejour) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-sejour-reject">Refuser</button>
                                <a href="{{ route('sejours.details.complete', $sejour->refsejour) }}" class="btn-sejour-primary">
                                Voir les détails
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
