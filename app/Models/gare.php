<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gare extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'gare',
        'longitude',
        'latitude',
        'voie',
        'actif',
        'id_utilisateur',
    ] ;
}
