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
        Schema::create('prise_services', function (Blueprint $table) {
            $table->id();
            $table->integer('id_agent');
            $table->integer('id_gare');
            $table->dateTime('date_heure') ;
            $table->boolean('actif') ;
            $table->integer('id_utilisateur')->nullable() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prise_services');
    }
};
