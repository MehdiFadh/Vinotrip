<?php

namespace App\Http\Controllers;

use App\Models\Partenaire;

class CaveController extends Controller
{
    public function show($id_partenaire)
    {
        $partenaire = Partenaire::with('cave')->where('id_partenaire', $id_partenaire)->firstOrFail();
        return view('cave.details', ['partenaire' => $partenaire, 'cave' => $partenaire->cave]);
    }
}

