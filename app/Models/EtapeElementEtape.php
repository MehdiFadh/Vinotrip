<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeElementEtape extends Model
{
    protected $table = 'etape_element_etape'; 

    public function etape()
    {
        return $this->belongsTo(Etape::class, 'id_etape');
    }

    public function elementEtape()
    {
        return $this->belongsTo(ElementEtape::class, 'idelement_etape');
    }
}
