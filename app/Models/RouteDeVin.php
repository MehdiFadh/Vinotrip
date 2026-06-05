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

    protected $fillable = [
        'nom_route_de_vins', 
    ];

    public function sejours()
    {
        return $this->belongsToMany(
            Sejour::class,                      
            'sejour_route_vin',     
            'num_route_de_vins',         
            'refsejour'                        
        );
    }
    public function sejourRouteVin()
    {
        return $this->hasMany(SejourRouteDeVin::class, 'num_route_de_vin', 'num_route_de_vin');
    }


}
