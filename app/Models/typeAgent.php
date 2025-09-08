<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type_agent',
        'actif',
        'id_utilisateur',
    ] ;
}
