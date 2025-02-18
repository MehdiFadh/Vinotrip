<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategorieParticipant extends Model
{
    use HasFactory;
    protected $table = "categorie_participant";
    protected $primaryKey = "idcategorie_participant";
    public $timestamps = false;

    protected $fillable = [
        'type_participant', 
    ];

    public function sejours()
    {
        return $this->belongsToMany(
            Sejour::class,                      
            'sejour_categorie_participant',     
            'idcategorie_participant',          
            'refsejour'                        
        );
    }
}
