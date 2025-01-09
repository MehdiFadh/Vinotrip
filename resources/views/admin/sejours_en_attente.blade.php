@extends('layouts.app')

@section('title', 'Séjours en Attente de Validation')

@section('content')
<div class="container">
    <h1>Séjours en Attente de Validation</h1>

    @if($sejoursEnAttente->isEmpty())
        <p>Aucun séjour en attente de validation.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Titre du Séjour</th>
                    <th>Destination</th>
                    <th>Prix (€)</th>
                    <th>Expiré le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sejoursEnAttente as $sejour)
                    <tr>
                        <td>{{ $sejour->titresejour }}</td>
                        <td>{{ $sejour->destination_sejour->nom_destination_sejour }}</td>
                        <td>{{ $sejour->prix_sejour }}</td>
                        <td>
                            @if($sejour->date_en_attente)
                                {{ $sejour->date_en_attente->format('d/m/Y H:i') }}
                            @else
                                <em>Aucune date d'attente</em>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('sejours.valider', $sejour->refsejour) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Valider</button>
                            </form>
                            <form action="{{ route('sejours.refuser', $sejour->refsejour) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">Refuser</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
