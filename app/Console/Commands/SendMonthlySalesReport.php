<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\MonthlySalesReport;
use App\Models\User; 
use App\Http\Controllers\SalesReportController;

class SendMonthlySalesReport extends Command
{
    protected $signature = 'sales:send-report';
    protected $description = 'Envoyer le rapport mensuel des ventes au directeur';

    public function handle()
    {
        $reportController = new SalesReportController();
        $filePath = $reportController->generateReportPDF();

        $director = User::where('role', 'dirigeant')->first(); // Modifiez si nécessaire

        if ($director) {
            $director->notify(new MonthlySalesReport($filePath));
            $this->info('Rapport mensuel envoyé avec succès.');
        } else {
            $this->error('Directeur non trouvé.');
        }

        return 0;
    }
}
