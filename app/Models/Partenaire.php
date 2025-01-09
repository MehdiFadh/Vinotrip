<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    use HasFactory;

    protected $table = 'partenaire'; // Nom de la table

    public $timestamps = false; // Pas de colonnes created_at ou updated_at

    protected $primaryKey = 'id_partenaire'; // Spécifier la clé primaire

    protected $fillable = [
        'id_partenaire', // La clé primaire
        'nom_partenaire',
        'tel_partenaire',
        'mailpartenaire',
        'site_partenaire',
        'refsejour', // Relation avec le séjour
    ];

    // Relation avec le modèle Hotel
    public function hotel()
    {
        return $this->hasOne(Hotel::class, 'id_partenaire', 'id_partenaire');
    }
    public function cave()
    {
        return $this->hasOne(Cave::class, 'id_partenaire', 'id_partenaire');
    }
    // Relation avec le modèle Sejour
    public function sejour()
    {
        return $this->belongsTo(Sejour::class, 'refsejour', 'refsejour');
    }

    // Relation avec le modèle ElementEtape
    public function elementEtapes()
    {
        return $this->hasMany(ElementEtape::class, 'id_partenaire', 'id_partenaire');
    }   
}

