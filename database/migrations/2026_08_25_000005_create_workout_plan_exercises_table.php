<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_plan_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_plan_day_id')->constrained('workout_plan_days')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('restrict');
            $table->tinyInteger('target_sets');
            $table->string('target_reps'); // e.g. "8-12" or "5"
            $table->decimal('target_weight', 8, 2)->nullable();
            $table->decimal('target_rir', 3, 1)->nullable();
            $table->decimal('target_rpe', 3, 1)->nullable();
            $table->integer('rest_time_seconds')->nullable();
            $table->string('tempo', 10)->nullable(); // e.g. "4010"
            $table->tinyInteger('order');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plan_exercises');
    }
};
