@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/rapport.css') }}">
<div class="container">
    <h1 class="text-center mb-4">Détails des Ventes par Séjour</h1>
    <div class="mb-4 text-center">
        <a href="{{ route('rapport.ventes') }}" class="btn btn-secondary mb-3">Retour au rapport mensuel</a>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="filter-destination">Filtrer par Destination</label>
            <select id="filter-destination" class="form-control">
                <option value="">Toutes les destinations</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination }}">{{ $destination }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="filter-categorie-sejour">Filtrer par Catégorie de Séjour</label>
            <select id="filter-categorie-sejour" class="form-control">
                <option value="">Toutes les catégories</option>
                @foreach ($categoriesSejour as $categorie)
                    <option value="{{ $categorie }}">{{ $categorie }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="filter-participant">Filtrer par Catégorie de Participant</label>
            <select id="filter-participant" class="form-control">
                <option value="">Toutes les catégories</option>
                @foreach ($categoriesParticipant as $participant)
                    <option value="{{ $participant }}">{{ $participant }}</option>
                @endforeach
            </select>
        </div>
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

    <!-- Tableau -->
    <table id="sejourTable" class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Destination</th>
                <th>Catégorie de Séjour</th>
                <th>Catégorie de Participant</th>
                <th>Séjour</th>
                <th>Nombre de Ventes</th>
                <th>Revenus (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $detail)
                <tr data-destination="{{ $detail->destination }}" 
                    data-categorie-sejour="{{ $detail->categorie_sejour }}" 
                    data-categorie-participant="{{ $detail->categorie_participant }}">
                    <td>{{ $detail->destination }}</td>
                    <td>{{ $detail->categorie_sejour }}</td>
                    <td>{{ $detail->categorie_participant }}</td>
                    <td>{{ $detail->sejour }}</td>
                    <td>{{ $detail->nombre_ventes }}</td>
                    <td>{{ number_format($detail->revenu, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const details = @json($details);  // Récupérer les données du tableau

        // Vérifier si des données existent
        if (!details || details.length === 0) {
            console.error("Aucune donnée disponible pour les graphiques.");
            return;
        }

        // Extraire les données pour les graphiques
        const labels = details.map(d => d.sejour || 'Non défini');
        const ventesData = details.map(d => parseInt(d.nombre_ventes) || 0);
        const revenusData = details.map(d => parseFloat(d.revenu) || 0);

        // Initialisation du graphique pour le nombre de ventes
        const ctx1 = document.getElementById('ventesChart').getContext('2d');
        const ventesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre de Ventes',
                    data: ventesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
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

        // Initialisation du graphique pour les revenus
        const ctx2 = document.getElementById('revenusChart').getContext('2d');
        const revenusChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenus (€)',
                    data: revenusData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
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

        // Fonction pour appliquer les filtres
        function applyFilters() {
            const selectedDestination = document.getElementById('filter-destination').value.trim();
            const selectedCategorieSejour = document.getElementById('filter-categorie-sejour').value.trim();
            const selectedParticipant = document.getElementById('filter-participant').value.trim();

            tableRows.forEach(row => {
                const matchesDestination = !selectedDestination || row.dataset.destination === selectedDestination;
                const matchesCategorieSejour = !selectedCategorieSejour || row.dataset.categorieSejour === selectedCategorieSejour;
                const matchesParticipant = !selectedParticipant || row.dataset.categorieParticipant === selectedParticipant;

                // Afficher ou masquer les lignes en fonction des filtres
                row.style.display = matchesDestination && matchesCategorieSejour && matchesParticipant ? '' : 'none';
            });
        }

        // Ajouter des écouteurs sur les listes déroulantes
        document.getElementById('filter-destination').addEventListener('change', applyFilters);
        document.getElementById('filter-categorie-sejour').addEventListener('change', applyFilters);
        document.getElementById('filter-participant').addEventListener('change', applyFilters);
    });
</script>
@endsection
