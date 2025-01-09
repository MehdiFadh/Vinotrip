<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDegustation extends Model
{
    use HasFactory;

    protected $table = 'type_degustation'; // Nom de la table

    public $timestamps = false; // Pas de colonnes created_at ou updated_at

    protected $primaryKey ='code_type_degustation';

    
}
