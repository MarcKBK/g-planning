<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeVehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type_vehicule',
        'actif',
        'id_utilisateur',
    ] ;
}


