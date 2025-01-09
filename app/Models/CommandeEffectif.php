<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;

class CommandeEffectif extends Model
{
    use HasFactory;

    protected $primaryKey = "numcommande";
    protected $table = 'commande_effectif';
    public $timestamps = false;

    protected $fillable = [
        'numcommande',
        'idclient',
        'date_commande',
        'message_commande',
        'date_debut_sejour',
        'duree_sejour',
        'etat_commande',
    ];
    
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'numcommande', 'numcommande');
    }
    
}