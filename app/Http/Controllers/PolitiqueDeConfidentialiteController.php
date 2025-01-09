<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolitiqueDeConfidentialiteController extends Controller
{
    public function index () {
        return view('politique_de_confidentialite');
    }
}
