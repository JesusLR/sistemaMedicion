<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutPlanExercise extends Model
{
    protected $fillable = [
        'workout_plan_day_id',
        'exercise_id',
        'target_sets',
        'target_reps',
        'target_weight',
        'target_rir',
        'target_rpe',
        'rest_time_seconds',
        'tempo',
        'order',
        'notes',
    ];

    protected $casts = [
        'target_sets' => 'integer',
        'target_weight' => 'decimal:2',
        'target_rir' => 'decimal:1',
        'target_rpe' => 'decimal:1',
        'rest_time_seconds' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the plan day this exercise belongs to.
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlanDay::class, 'workout_plan_day_id');
    }

    /**
     * Get the master exercise details.
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
