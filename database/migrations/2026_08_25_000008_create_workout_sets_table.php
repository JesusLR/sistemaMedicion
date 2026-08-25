<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_exercise_id')->constrained('workout_exercises')->onDelete('cascade');
            $table->tinyInteger('set_number');
            $table->decimal('weight', 8, 2);
            $table->integer('reps');
            $table->decimal('rir', 3, 1)->nullable();
            $table->decimal('rpe', 3, 1)->nullable();
            $table->integer('rest_actual_seconds')->nullable();
            $table->boolean('is_completed')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_sets');
    }
};
