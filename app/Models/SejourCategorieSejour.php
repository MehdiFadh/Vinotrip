<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejourCategorieSejour extends Model
{
    use HasFactory;

    protected $table = 'sejour_categorie_sejour';

    public function sejour()
    {
        return $this->belongsTo(Sejour::class);
    }

    public function categorieSejour()
    {
        return $this->belongsTo(CategorieSejour::class);
    }
}
