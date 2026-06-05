<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Avis extends Model
{
    use HasFactory;
    
    protected $table = "avis";
    protected $primaryKey = "numavis";

    public $timestamps = false;

    public function sejour(): HasOne{
        return $this->hasOne(
            Sejour::class,                   
            "refsejour",
            "refsejour");
    }

    public function client(): HasOne{
        return $this->hasOne(
            Client::class,                   
            "idclient",
            "idclient");
    }

    public function getDateavisAttribute($value)
    {
        return Carbon::parse($value);
    }
}
