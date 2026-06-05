<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CommandeCadeau extends Model
{
    use HasFactory;

    protected $table = 'commande_cadeau';
    public $timestamps = false;

    protected $fillable = [
        'numcommande',
        'idclient',
        'date_commande',
        'message_commande',
        'code_cadeau',
        'etat_commande',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'numcommande', 'numcommande');
    }

}