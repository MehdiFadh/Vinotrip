<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejourCategorieParticipant extends Model
{
    use HasFactory;

    protected $table = 'sejour_categorie_participant';

    // Relation inverse avec Séjour
    public function sejour()
    {
        return $this->belongsTo(Sejour::class);
    }
}
