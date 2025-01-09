<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel'; // Nom de la table

    public $timestamps = false; // Pas de colonnes created_at ou updated_at

    protected $fillable = [
        'id_partenaire',
        'categorie_',
        'nb_chambres',
    ];

    // Relation avec le modèle Partenaire
    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class, 'id_partenaire');
    }
}
