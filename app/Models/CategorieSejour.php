<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategorieSejour extends Model
{
    use HasFactory;
    protected $table = "categorie_sejour";
    protected $primaryKey = "idcategoriesejour";
    public $timestamps = false;

    public function sejourCategorieSejour()
    {
        return $this->belongsTo(sejourCategorieSejour::class);
    }
    public function sejours()
    {
        return $this->belongsToMany(
            Sejour::class,                      // Modèle lié
            'sejour_categorie_sejour',     // Nom de la table intermédiaire
            'idcategoriesejour',          // Colonne de clé étrangère dans la table intermédiaire pointant vers ce modèle
            'refsejour'                         // Colonne de clé étrangère dans la table intermédiaire pointant vers le modèle Sejour
        );
    }
}