@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/rapport.css') }}">
<div class="container">
    <h1 class="text-center mb-4">Rapport Mensuel des Ventes</h1>

    <div class="mb-4 text-center">
        <a href="{{ route('rapport.sejours') }}" class="btn btn-secondary">Afficher les détails des séjours</a>
        <a href="{{ route('rapport.vignobles') }}" class="btn btn-secondary">Rapport des Ventes par Vignoble</a>
        <a href="{{ route('rapport.zone.geographique') }}" class="btn btn-secondary ">Rapport des Ventes par Zone Géographique</a>
    </div>

    <!-- Graphiques côte à côte -->
    <div class="row mb-4">
        <div class="col-md-6">
            <canvas id="ventesChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="revenusChart"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Nombre de Séjours Vendus</th>
                        <th>Revenus (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mois as $index => $moisLabel)
                        <tr>
                            <td>{{ $moisLabel }}</td>
                            <td>{{ $ventes[$index] }}</td>
                            <td>{{ number_format($revenus[$index], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des Ventes
    const ctx1 = document.getElementById('ventesChart').getContext('2d');
    const ventesChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: {!! json_encode($mois) !!},
            datasets: [
                {
                    label: 'Nombre de Séjours Vendus',
                    data: {!! json_encode($ventes) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique des Revenus
    const ctx2 = document.getElementById('revenusChart').getContext('2d');
    const revenusChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($mois) !!},
            datasets: [
                {
                    label: 'Revenus (€)',
                    data: {!! json_encode($revenus) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
