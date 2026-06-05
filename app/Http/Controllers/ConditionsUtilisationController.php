<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConditionsUtilisationController extends Controller
{
    public function index () {
        return view('conditions_utilisation');
    }
}
