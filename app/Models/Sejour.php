<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;


class Sejour extends Model
{
    use HasFactory;

    protected $table = "sejour";
    protected $primaryKey = "refsejour";
    public $timestamps = false;
    
    protected $fillable = [
        'idtheme',
        'num_destination_sejour',
        'titresejour',
        'descriptionsejour',
        'prix_sejour',
        'url_photo_sejour',
    ];

    public function domaines()
    {
        return $this->hasMany(Domaine::class);
    }

    public function destination_sejour(): hasOne{
        return $this->hasOne(
            Destination::class,                   
            "num_destination_sejour",
            "num_destination_sejour");
    }
    
    public function categorieParticipants()
    {
        return $this->belongsToMany(CategorieParticipant::class, 'sejour_categorie_participant','refsejour','idcategorie_participant');
    }

    public function commandeSejours()
    {
        return $this->hasMany(CommandeSejour::class, 'refsejour', 'refsejour');
    }

    public function categorieSejours()
    {
        return $this->belongsToMany(
            CategorieSejour::class,         // Modèle lié
            'sejour_categorie_sejour',      // Table intermédiaire
            'refsejour',                    // Clé étrangère dans la table intermédiaire pointant vers ce modèle
            'idcategoriesejour'            // Clé étrangère pointant vers le modèle `CategorieSejour`
        );
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'refsejour', 'refsejour');
    }
    
    public function routesDeVins()
    {
        return $this->belongsToMany(RouteDeVin::class, 'sejour_route_vin', 'refsejour', 'num_route_de_vins');
    }


    public function etapes()
    {
        return $this->hasMany(Etape::class, 'refsejour', 'refsejour');
    }
    // Assurez-vous que la relation est bien définie
    public function partenaires()
    {
        return $this->hasMany(Partenaire::class, 'id_partenaire', 'refsejour');
    }


}
