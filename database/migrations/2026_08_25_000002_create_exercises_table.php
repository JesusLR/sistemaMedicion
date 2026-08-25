<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('muscle_group')->index(); // e.g. Pecho, Espalda, Pierna
            $table->string('primary_muscle'); // e.g. Pectoral Mayor, Cuádriceps
            $table->json('secondary_muscles')->nullable(); // e.g. ['Tríceps', 'Deltoides Anterior']
            $table->string('exercise_type'); // e.g. Fuerza, Aislamiento, Cardio
            $table->string('equipment'); // e.g. Barra, Mancuernas, Cable, Peso Corporal
            $table->string('difficulty'); // e.g. Principiante, Intermedio, Avanzado
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
