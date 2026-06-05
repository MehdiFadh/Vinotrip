<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdresseClient extends Model
{
    use HasFactory;

    protected $table = 'adresse_client';
    protected $primaryKey = 'code_adresse_client'; 
    public $timestamps = false;

    protected $fillable = [
        'idclient',
        'nom_adresse_client',
        'rue_client',
        'ville_client',
        'code_postal_client',
        'pays_client',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'idclient');
    }
}
