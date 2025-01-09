<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;


class RouteDeVin extends Model
{
    use HasFactory;
    
    protected $table = "route_de_vins";
    protected $primaryKey = "num_route_de_vins";
    public $timestamps = false;

    public function sejours()
    {
        return $this->belongsToMany(
            Sejour::class,                      // Modèle lié
            'sejour_route_vin',     // Nom de la table intermédiaire
            'num_route_de_vins',          // Colonne de clé étrangère dans la table intermédiaire pointant vers ce modèle
            'refsejour'                         // Colonne de clé étrangère dans la table intermédiaire pointant vers le modèle Sejour
        );
    }
    public function sejourRouteVin()
    {
        return $this->hasMany(SejourRouteDeVin::class, 'num_route_de_vin', 'num_route_de_vin');
    }


}
