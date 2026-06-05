<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;  

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }
    /*Méthode de connexion*/
    public function login(Request $request)
    { 
        $validated = $request->validate([
            'mailclient' => 'required|email', 
            'mot_de_passe_client' => 'required|min:8',
            
        ]);

        $user = User::where('mailclient', $request->mailclient)->first();

        if ($user && Hash::check($request->mot_de_passe_client, $user->mot_de_passe_client)) {
            $user->update([
                'datederniereactivite'=> now(),
            ]);
            Auth::login($user);  
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'mailclient' => ['Les informations de connexion sont incorrectes.'],
        ]);
    }
    /*Méthode de déconnexion*/

    public function logout()
    {

        Auth::logout();

        return redirect('/');
    }
}
