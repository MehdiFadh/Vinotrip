<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDegustation extends Model
{
    use HasFactory;

    protected $table = 'type_degustation'; 

    public $timestamps = false; 

    protected $primaryKey ='code_type_degustation';

    
}
