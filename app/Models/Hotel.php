<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';

    public $timestamps = false; 

    protected $fillable = [
        'id_partenaire',
        'categorie_',
        'nb_chambres',
    ];

    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class, 'id_partenaire');
    }
}
