<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieParticipant;

class CategorieParticipantController extends Controller
{
    public function index () {
        return view('sejours', [
            'categorie_participant' => CategorieParticipant::all()
        ]);
    }
}
