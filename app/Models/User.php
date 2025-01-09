<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'client';  

    protected $primaryKey = 'idclient';

    public $incrementing = true;  

    // Désactiver la gestion automatique des timestamps
    public $timestamps = false;

    protected $fillable = [
        'nomclient',
        'prenomclient',
        'mailclient',
        'datenaissance',
        'telclient',
        'mot_de_passe_client',
        'datederniereactivite',
        'role',
    ];

    protected $hidden = [
        'mot_de_passe_client',
    ];

    protected $casts = [
        'datenaissance' => 'date',
    ];
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'idclient');
    }

    public function anonymize()
    {
        // Anonymiser les champs de l'utilisateur
        $this->update([
            'nomclient' => 'Anonyme',
            'prenomclient' => 'Anonyme',
            'mailclient' => 'anonyme_' . $this->idclient . '@example.com',
            'telclient' => null,
            'mot_de_passe_client' => bcrypt('anonyme'),
        ]);

        // Anonymiser les adresses associées
        foreach ($this->adresses as $adresse) {
            $adresse->anonymize();
        }
    }
}
