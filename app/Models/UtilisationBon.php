<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisationBon extends Model
{
    use HasFactory;

    protected $table = "utilisation_bon";

    protected $timestamp = false;

    protected $fillable = [
        'numcommande',
        'code_bon_de_reduction'
    ];


    public function commande()
    {
        return $this->belongsTo(Commande::class, 'numcommande');
    }
}
