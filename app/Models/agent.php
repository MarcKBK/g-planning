<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'depot',
        'nom',
        'prenom',
        'matricule',
        'photo',
        'actif',
        'id_utilisateur',
    ] ;
}
