<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rapport Mensuel des Ventes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Rapport Mensuel des Ventes</h1>
    <table>
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
</body>
</html>
