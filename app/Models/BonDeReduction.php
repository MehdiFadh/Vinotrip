<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeReduction extends Model
{
    use HasFactory;

    protected $table = 'bon_de_reduction';

    protected $fillable = [
        'code_bon_de_reduction',
        'date_creation',
        'montant_bon'
    ];

    protected $timestamp = false;

    public function utilisation_bon()
    {
        return $this->belongsTo(UtilisationBon::class);
    }

}
