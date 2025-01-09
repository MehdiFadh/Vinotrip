<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cave extends Model
{
    use HasFactory;

    protected $table = 'cave_a_vin'; // Nom exact de votre table
    protected $primaryKey = 'id_partenaire'; // Clé primaire
    public $timestamps = false; // Si pas de colonnes created_at et updated_at

    protected $fillable = [
        'id_partenaire',
        'code_type_degustation',
    ];

    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class, 'id_partenaire', 'id_partenaire');
    }
    public function type_degustation()
    {
        return $this->belongsTo(TypeDegustation::class, 'code_type_degustation', 'code_type_degustation');
    }
}
