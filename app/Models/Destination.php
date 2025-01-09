<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = "destination_sejour";
    protected $primaryKey = "num_destination_sejour";

    public $timestamps = false;

    public function sejours()
    {
        return $this->hasMany(Sejour::class, 'num_destination_sejour', 'num_destination_sejour');
    }

}
