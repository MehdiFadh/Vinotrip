<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormulaireMail;


use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index () {
        return view('nous_contacter');
    }


    public function formulaire(Request $request)
    {

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        

        Mail::to('vinotrip1@gmail.com')->send(new ContactFormulaireMail($validatedData));

        session()->flash('success', 'Votre message à été envoyé à l\'équipe vinotrip.');
        return redirect()->back();
    }

}
