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
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('word_opposite_1')->nullable();
            $table->string('image')->nullable();
            $table->string('audio_arabic')->nullable();
            $table->string('traduction_arabic')->nullable();
            $table->string('transcription_arabic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};
