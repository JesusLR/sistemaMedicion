<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutPlanDay extends Model
{
    protected $fillable = [
        'workout_plan_id',
        'day_number',
        'name',
    ];

    /**
     * Get the workout plan this day belongs to.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlan::class, 'workout_plan_id');
    }

    /**
     * Get the exercises mapped to this day.
     */
    public function exercises(): HasMany
    {
        return $this->hasMany(WorkoutPlanExercise::class, 'workout_plan_day_id')->orderBy('order');
    }

    /**
     * Get the workouts performed based on this day.
     */
    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }
}
