<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieSejour;

class CategorieSejourController extends Controller
{
    public function index () {
        return view('sejours', [
            'categorie_sejour' => CategorieSejour::all()
        ]);
    }
}