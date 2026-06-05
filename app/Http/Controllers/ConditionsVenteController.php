<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConditionsVenteController extends Controller
{
    public function index () {
        return view('conditions_vente');
    }
}
