<?php

function stressTest($url, $concurrentRequests, $totalRequests) {
    $multiHandle = curl_multi_init();
    $handles = [];
    $completedRequests = 0;

    // Créer un pool de requêtes concurrentes
    for ($i = 0; $i < $concurrentRequests; $i++) {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $handles[] = $handle;
        curl_multi_add_handle($multiHandle, $handle);
    }

    do {
        // Exécuter les requêtes dans le pool
        do {
            $status = curl_multi_exec($multiHandle, $active);
        } while ($status == CURLM_CALL_MULTI_PERFORM);

        // Vérifier les requêtes terminées
        while ($completed = curl_multi_info_read($multiHandle)) {
            $handle = $completed['handle'];
            $response = curl_multi_getcontent($handle); // Réponse de la requête
            $info = curl_getinfo($handle); // Informations sur la requête

            // Afficher les informations de la requête
            echo "Request completed:\n";
            echo "HTTP Code: " . $info['http_code'] . "\n";
            echo "Time Taken: " . $info['total_time'] . " seconds\n\n";

            $completedRequests++;
            curl_multi_remove_handle($multiHandle, $handle);
            curl_close($handle);

            // Ajouter une nouvelle requête si nécessaire
            if ($completedRequests < $totalRequests) {
                $newHandle = curl_init($url);
                curl_setopt($newHandle, CURLOPT_RETURNTRANSFER, true);
                curl_multi_add_handle($multiHandle, $newHandle);
                $handles[] = $newHandle;
            }
        }

        // Pause pour éviter de surcharger la boucle
        usleep(10000);

    } while ($active || $completedRequests < $totalRequests);

    // Nettoyage
    curl_multi_close($multiHandle);

    echo "Test terminé : $completedRequests requêtes exécutées.\n";
}

// URL de votre site Laravel
$url = "http://51.83.36.122:3630";

// Paramètres du test
$concurrentRequests = 20; // Nombre de requêtes simultanées
$totalRequests = 1000; // Nombre total de requêtes à effectuer

stressTest($url, $concurrentRequests, $totalRequests);

