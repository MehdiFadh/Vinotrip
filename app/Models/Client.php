<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Client extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = "client";
    protected $primaryKey = "idclient";
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

    public function adresses()
    {
        return $this->hasMany(AdresseClient::class, 'idclient');
    }

}
