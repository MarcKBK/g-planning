<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prise_service extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_agent',
        'id_gare',
        'date_heure',
        'actif',
        'id_utilisateur',
    ] ;
}
