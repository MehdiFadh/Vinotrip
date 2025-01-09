<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejourRouteDeVin extends Model
{
    use HasFactory;

    
    protected $table = 'sejour_route_vin';


    public function sejour()
    {
        return $this->belongsTo(Sejour::class);
    }

    public function route_de_vins()
    {
        return $this->belongsTo(RouteDeVin::class);
    }
}