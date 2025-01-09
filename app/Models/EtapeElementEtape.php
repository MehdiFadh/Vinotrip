<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeElementEtape extends Model
{
    // Nom de la table
    protected $table = 'etape_element_etape'; 

    // Définir les relations avec les modèles Etape et ElementEtape
    public function etape()
    {
        return $this->belongsTo(Etape::class, 'id_etape');
    }

    public function elementEtape()
    {
        return $this->belongsTo(ElementEtape::class, 'idelement_etape');
    }
}
