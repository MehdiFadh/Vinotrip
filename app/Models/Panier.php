<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'panier';
    protected $primaryKey = "id";
    public $timestamps = false;
    

    protected $fillable = [
        'numcommande',
        'options',
        'prix_total',
    ];

    protected $casts = [
        'options' => 'array', // Cast JSON options to PHP array
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'numcommande', 'numcommande');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'idclient', 'idclient');
    }

    public function afficherPanierCommande($numcommande)
    {
        $panierItems = Panier::where('numcommande', $numcommande)->get();

        return view('commandes.panier', [
            'panierItems' => $panierItems,
            'numcommande' => $numcommande,
        ]);
    }

}
