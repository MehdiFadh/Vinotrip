<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avis;

class AvisController extends Controller
{
    public function index () {
        return view('welcome', [
            'avis' => Avis::all()
        ]);
    }
}
