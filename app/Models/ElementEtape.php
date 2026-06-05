<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ElementEtape extends Model
{
    use HasFactory;
    protected $table = "element_etape";
    protected $primaryKey = "idelement_etape";
    public $timestamps = false;

    protected $fillable = [
        'nom_element_etape', 
    ];

    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class, 'id_partenaire');
    }

    public function etape()
    {
        return $this->belongsTo(Etape::class, 'idelement_etape', 'id_etape');
    }
}

