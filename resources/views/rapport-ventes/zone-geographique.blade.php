@extends('layouts.app')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<link rel="stylesheet" href="{{ asset('css/rapport.css') }}">
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="container">
    <h1 class="text-center mb-4">Rapport Mensuel des Ventes par Zone Géographique</h1>
    <div class="mb-4 text-center">
        <a href="{{ route('rapport.ventes') }}" class="btn btn-secondary mb-3">Retour au rapport général</a>
    </div>

    <!-- Carte -->
    <div id="map" style="height: 500px; margin-bottom: 20px;"></div>

    <table class="table table-bordered text-center">
    <thead class="thead-dark">
        <tr>
            <th>Pays</th>
            <th>Région</th> <!-- Nouvelle colonne -->
            <th>Ville</th>
            <th>Nombre de Ventes</th>
            <th>Revenus (€)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($zonesGeographiques as $zone)
            <tr>
                <td>{{ $zone->pays }}</td>
                <td>{{ $zone->region }}</td> <!-- Affichage de la région -->
                <td>{{ $zone->ville }}</td>
                <td>{{ $zone->nombre_ventes }}</td>
                <td>{{ number_format($zone->revenus, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Aucune vente enregistrée pour ce mois.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte
    const map = L.map('map').setView([45.764, 4.8357], 6); // Vue centrée sur la France

    // Ajouter les tuiles de la carte
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Ajouter les cercles proportionnels
    const zones = @json($zonesGeographiques); // Cette ligne permet de transmettre la variable à JavaScript
    console.log("Données zones géographiques :", zones); // Vérifier les données dans la console

    zones.forEach(zone => {
        console.log(`Traitement de la zone pour ${zone.ville} (${zone.pays})`);

        // Vérifier si latitude et longitude existent et sont valides
        if (zone.latitude && zone.longitude && !isNaN(zone.latitude) && !isNaN(zone.longitude)) {
            const lat = parseFloat(zone.latitude);
            const lon = parseFloat(zone.longitude);
            console.log(`Latitude : ${lat}, Longitude : ${lon}`);
            
            // Vérifier si 'revenus' est un nombre et le convertir
            const revenus = !isNaN(zone.revenus) ? parseFloat(zone.revenus) : 0; // Si non numérique, mettre 0 par défaut

            // Ajouter le cercle pour chaque zone
            L.circle([lat, lon], {
            color: 'blue',
            fillColor: '#1E90FF',
            fillOpacity: 0.5,
            radius: zone.nombre_ventes * 2000,
        }).bindPopup(`
            <strong>${zone.ville}, ${zone.region} (${zone.pays})</strong><br> <!-- Région ajoutée -->
            Ventes : ${zone.nombre_ventes}<br>
            Revenus : ${revenus.toFixed(2)} €
            `).addTo(map);

        } else {
            // Log des erreurs si les coordonnées sont manquantes ou invalides
            console.error(`Coordonnées manquantes ou invalides pour la ville ${zone.ville}`);
        }
    });
});

</script>
@endsection
