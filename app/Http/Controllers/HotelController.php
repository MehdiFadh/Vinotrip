<?php
namespace App\Http\Controllers;
use App\Models\Partenaire;

class HotelController extends Controller
{
    public function show($id_partenaire)
    {
        $partenaire = Partenaire::findOrFail($id_partenaire);

        $hotel = $partenaire->hotel;

        return view('hotels.details', ['partenaire' => $partenaire, 'hotel' => $hotel]);
    }
}