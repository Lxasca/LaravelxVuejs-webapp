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
        // Table Exercices
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            // Relation avec la table Levels (niveaux) car un exercice appartient à un niveau
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->string('scenario')->nullable();
            $table->string('type')->nullable(); // Type d'exercice : par exemple "vocabulary", et dans ce cas on va chercher vocabulary_id
            $table->integer('order')->nullable();

            // Vocabulaire associé si type == 'vocabulary'
            $table->foreignId('vocabulary_id')->nullable()->constrained('vocabularies')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
