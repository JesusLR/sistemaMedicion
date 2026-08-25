<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutSet extends Model
{
    protected $fillable = [
        'workout_exercise_id',
        'set_number',
        'weight',
        'reps',
        'rir',
        'rpe',
        'rest_actual_seconds',
        'is_completed',
    ];

    protected $casts = [
        'set_number' => 'integer',
        'weight' => 'decimal:2',
        'reps' => 'integer',
        'rir' => 'decimal:1',
        'rpe' => 'decimal:1',
        'rest_actual_seconds' => 'integer',
        'is_completed' => 'boolean',
    ];

    /**
     * Get the workout exercise this set belongs to.
     */
    public function workoutExercise(): BelongsTo
    {
        return $this->belongsTo(WorkoutExercise::class, 'workout_exercise_id');
    }
}
