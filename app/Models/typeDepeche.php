<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeDepeche extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type_depeche',
        'actif',
        'id_utilisateur',
    ] ;
}
