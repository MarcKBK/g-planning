<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class depeche extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_gare',
        'id_type',
        'id_vehicule',
        'id_agent_entree_remis',
        'id_agent_entre_recu',
        'date_entree',
        'date_prevue_sortie',
        'id_agent_sortie_remis',
        'id_agent_sortie_recu',
        'date_sortie',
        'actif',
        'id_utilisateur',

    ] ;
}

