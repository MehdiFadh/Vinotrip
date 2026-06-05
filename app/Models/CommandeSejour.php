<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;

class CommandeSejour extends Model
{
    use HasFactory;

    protected $primaryKey = ['numcommande', 'refsejour'];    
    protected $table = 'commande_sejour';
    public $timestamps = false;

    protected $fillable = [
        'numcommande',
        'nbr_adulte',
        'nbr_enfant',
        'nbr_chambre',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'numcommande', 'numcommande');
    }

    public function sejour()
    {
        return $this->belongsTo(Sejour::class, 'refsejour', 'refsejour');
    }
    
}