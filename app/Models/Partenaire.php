<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    use HasFactory;

    protected $table = 'partenaire'; 

    public $timestamps = false;

    protected $primaryKey = 'id_partenaire'; 

    protected $fillable = [
        'id_partenaire', 
        'nom_partenaire',
        'tel_partenaire',
        'mailpartenaire',
        'site_partenaire',
        'refsejour', 
    ];

    public function hotel()
    {
        return $this->hasOne(Hotel::class, 'id_partenaire', 'id_partenaire');
    }
    public function cave()
    {
        return $this->hasOne(Cave::class, 'id_partenaire', 'id_partenaire');
    }
    public function sejour()
    {
        return $this->belongsTo(Sejour::class, 'refsejour', 'refsejour');
    }

    public function elementEtapes()
    {
        return $this->hasMany(ElementEtape::class, 'id_partenaire', 'id_partenaire');
    }   
}

