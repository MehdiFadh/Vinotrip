<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Twilio\Rest\Client;


class SmsController extends Controller
{
    public function sendSmsTest()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER'); 
        $to = '+1234567890'; 
        if (empty($sid) || empty($token)) {
            return response()->json([
                'success' => false,
                'error' => 'Les identifiants Twilio sont manquants dans le fichier .env'
            ], 400);
        }
        $client = new Client($sid, $token);
        try {
            $message = $client->messages->create(
                $to, 
                [
                    'from' => $from, 
                    'body' => 'Ceci est un message de test depuis Twilio.' 
                ]
            );
            return response()->json([
                'success' => true,
                'message' => 'SMS envoyé avec succès!',
                'sid' => $message->sid 
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur Twilio: ' . $e->getMessage()
            ], 500);
        }
    }
}
