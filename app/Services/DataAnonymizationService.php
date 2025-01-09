<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class DataAnonymizationService
{
    /**
     * Anonymiser les utilisateurs inactifs avant une date limite.
     *
     * @param Carbon $dateLimit
     * @return int Le nombre d'utilisateurs anonymisés.
     */
    public function anonymizeUsersBeforeDate(Carbon $dateLimit)
    {
        // Sélectionner les utilisateurs inactifs
        $users = User::where('datederniereactivite', '<', $dateLimit)->get();

        foreach ($users as $user) {
            $user->anonymize();
        }

        return count($users);
    }
}
