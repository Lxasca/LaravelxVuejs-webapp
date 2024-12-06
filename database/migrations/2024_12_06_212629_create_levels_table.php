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
        // Table Niveaux
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            // Relation avec courses : un niveau est lié à un Parcours,
            // par exemple le niveau 1 du parcours Diplomatie
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->integer('order')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
