<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;

class ChequeCadeau extends Model
{
    use HasFactory;

    protected $primaryKey = "id_cheque_cadeau";
    protected $table = 'cheque_cadeau';
    public $timestamps = false;

    protected $fillable = [
        'numcommande',
        'code_cheque',
        'montant_cheque',
        'id_beneficiaire',
        'message_cheque',
        'nom_offrant',
        'date_achat',
    ];
    
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'numcommande', 'numcommande');
    }
    
}