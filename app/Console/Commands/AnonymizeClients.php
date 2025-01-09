<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;
use App\Models\AdresseClient;
use Carbon\Carbon;

class AnonymizeClients extends Command
{
    protected $signature = 'clients:anonymize {--months=60}';
    protected $description = 'Anonymize clients and their addresses based on the last activity date';

    public function handle()
    {
        $months = $this->option('months');
        $thresholdDate = Carbon::now()->subMonths($months);

        // Sélectionner les clients inactifs
        $clients = Client::where('datederniereactivite', '<', $thresholdDate)->get();

        if ($clients->isEmpty()) {
            $this->info("Aucun client à anonymiser.");
            return 0;
        }

        foreach ($clients as $client) {
            // Anonymiser les adresses associées
            $this->anonymizeAddresses($client);

            // Anonymiser le client
            $client->update([
                'nomclient' => 'Anonyme',
                'prenomclient' => 'Anonyme',
                'mailclient' => 'anonyme_' . $client->idclient . '@example.com',
                'datenaissance' => null,
                'telclient' => null,
                'mot_de_passe_client' => null,
                'role' => 'anonyme',
            ]);

            $this->info("Client {$client->idclient} anonymisé.");
        }

        return 0;
    }

    private function anonymizeAddresses(Client $client)
    {
        foreach ($client->adresses as $adresse) {
            $adresse->update([
                'nom_adresse_client' => 'Anonyme',
                'rue_client' => null,
                'ville_client' => null,
                'code_postal_client' => null,
                'pays_client' => null,
            ]);

            $this->info("Adresse {$adresse->code_adresse_client} anonymisée.");
        }
    }
}
