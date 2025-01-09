<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategorieParticipant extends Model
{
    use HasFactory;
    protected $table = "categorie_participant";
    protected $primaryKey = "idcategorie_participant";
    public $timestamps = false;

    public function sejours()
    {
        return $this->belongsToMany(
            Sejour::class,                      // Modèle lié
            'sejour_categorie_participant',     // Nom de la table intermédiaire
            'idcategorie_participant',          // Colonne de clé étrangère dans la table intermédiaire pointant vers ce modèle
            'refsejour'                         // Colonne de clé étrangère dans la table intermédiaire pointant vers le modèle Sejour
        );
    }
}
