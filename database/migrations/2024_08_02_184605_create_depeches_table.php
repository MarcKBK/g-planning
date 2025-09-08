<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('depeches', function (Blueprint $table) {
            $table->id();
            $table->integer('id_gare') ;
            $table->integer('id_type') ;
            $table->integer('id_vehicule') ;
            $table->integer('id_agent_entree_remis') ;
            $table->integer('id_agent_entre_recu') ;
            $table->date('date_entree');
            $table->date('date_prevue_sortie')->nullable();
            $table->integer('id_agent_sortie_remis')->nullable();
            $table->integer('id_agent_sortie_recu')->nullable(); ;
            $table->date('date_sortie')->nullable();
            $table->boolean('actif') ;
            $table->integer('id_utilisateur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depeches');
    }
};
