<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commande';
    protected $primaryKey = 'numcommande';
    public $timestamps = false;

    protected $fillable = [
        'idclient',
        'date_commande',
        'message_commande',
        'date_mise_a_jour',
        'etat_commande'
    ];



    public function clients()
    {
        return $this->belongsTo(User ::class, 'idclient');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'idclient');
    }

    public function sejour()
    {
        return $this->belongsTo(Sejour::class, 'refsejour');
    }

    public function commandeSejour()
    {
        return $this->hasOne(CommandeSejour::class, 'numcommande', 'numcommande');
    }

    public function cadeau()
    {
        return $this->hasOne(CommandeCadeau::class, 'numcommande');
    }
    public function cadeaux()
    {
        return $this->hasMany(CommandeCadeau::class, 'numcommande', 'numcommande');
    }

    public function commandeEffectifs()
    {
        return $this->hasMany(CommandeEffectif::class, 'numcommande', 'numcommande');
    }
    public function ChequeCadeau()
    {
        return $this->hasMany(ChequeCadeau::class, 'numcommande', 'numcommande');
    }
    public function facture()
    {
        return $this->hasOne(Facture::class, 'numcommande', 'numcommande');
    }
}
