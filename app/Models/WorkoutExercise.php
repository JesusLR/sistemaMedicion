<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutExercise extends Model
{
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'order',
        'notes',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the workout session this exercise was performed in.
     */
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }

    /**
     * Get the master exercise details.
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Get the sets performed for this exercise.
     */
    public function sets(): HasMany
    {
        return $this->hasMany(WorkoutSet::class, 'workout_exercise_id')->orderBy('set_number');
    }
}
