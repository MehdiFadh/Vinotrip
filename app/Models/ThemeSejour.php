<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSejour extends Model
{
    use HasFactory;

    protected $table = 'theme_sejour'; 
    protected $primaryKey = 'idtheme'; 

    public $timestamps = false;

    protected $fillable = [
        'nom_theme_sejour', 
    ];

}
