<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type_absence',
        'actif',
        'id_utilisateur',
    ] ;
}
