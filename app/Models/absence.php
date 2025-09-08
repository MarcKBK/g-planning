<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absence extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_type',
        'id_agent',
        'date_debut',
        'date_fin',
        'actif',
        'id_utilisateur',
    ] ;
}
