@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/rapport.css') }}">
<div class="container">
    <h1 class="text-center mb-4">Rapport des Ventes par Vignoble</h1>
    <div class="mb-4 text-center">
        <a href="{{ route('rapport.ventes') }}" class="btn btn-secondary mb-3">Retour au rapport général</a>
    </div>

    <!-- Graphiques côte à côte -->
    <div class="row mb-4">
        <div class="col-md-6">
            <canvas id="salesChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="revenuesChart"></canvas>
        </div>
    </div>

    <!-- Tableau des données -->
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Vignoble</th>
                        <th>Nombre de Séjours Vendus</th>
                        <th>Revenus (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vignobles as $vignoble)
                        <tr>
                            <td>{{ $vignoble->vignoble }}</td>
                            <td>{{ $vignoble->nombre_sejours }}</td>
                            <td>{{ number_format($vignoble->revenus, 2, ',', ' ') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Aucune vente enregistrée pour ce mois.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données des vignobles
        const vignobles = @json($vignobles);  // On récupère les données des vignobles

        // Vérification dans la console
        console.log("Données des vignobles :", vignobles);

        // Vérifier si des données existent
        if (!vignobles || vignobles.length === 0) {
            console.error("Aucune donnée disponible pour les graphiques.");
            return;
        }

        // Extraire les données pour les graphiques
        const labels = vignobles.map(v => v.vignoble || 'Non défini');  // Noms des vignobles
        const ventesData = vignobles.map(v => parseInt(v.nombre_sejours) || 0);  // Nombre de séjours
        const revenusData = vignobles.map(v => parseFloat(v.revenus) || 0);  // Revenus

        // Initialisation du graphique pour le nombre de séjours
        const ctx1 = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,  // Labels sur l'axe X
                datasets: [{
                    label: 'Nombre de Séjours Vendus',
                    data: ventesData,  // Données pour le nombre de séjours
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true  // Commencer l'axe Y à zéro
                    }
                }
            }
        });

        // Initialisation du graphique pour les revenus
        const ctx2 = document.getElementById('revenuesChart').getContext('2d');
        const revenuesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels,  // Labels sur l'axe X
                datasets: [{
                    label: 'Revenus (€)',
                    data: revenusData,  // Données pour les revenus
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true  // Commencer l'axe Y à zéro
                    }
                }
            }
        });
    });
</script>
@endsection
