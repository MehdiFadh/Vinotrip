<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Etape extends Model
{
    use HasFactory;
    protected $table = "etape";
    protected $primaryKey = "id_etape";
    public $timestamps = false;

    public function elementEtapes()
    {
        // Relation many-to-many via la table de liaison etape_element_etape
        return $this->belongsToMany(ElementEtape::class, 'etape_element_etape', 'id_etape', 'idelement_etape');
    }

    public function sejour()
    {
        return $this->belongsTo(Sejour::class, 'refsejour', 'refsejour');
    }
}
