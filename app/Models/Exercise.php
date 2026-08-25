<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'description',
        'muscle_group',
        'primary_muscle',
        'secondary_muscles',
        'exercise_type',
        'equipment',
        'difficulty',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'secondary_muscles' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the routine plan associations for this exercise.
     */
    public function workoutPlanExercises(): HasMany
    {
        return $this->hasMany(WorkoutPlanExercise::class);
    }

    /**
     * Get the performed workout instances of this exercise.
     */
    public function workoutExercises(): HasMany
    {
        return $this->hasMany(WorkoutExercise::class);
    }
}
