<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutPlanDay;
use Carbon\Carbon;

class WorkoutService
{
    /**
     * Start a new workout session for a user.
     */
    public function startWorkout(User $user, ?WorkoutPlanDay $planDay = null, ?string $customName = null): Workout
    {
        $name = $customName ?: 'Entrenando Libre';
        if ($planDay) {
            $name = $planDay->plan->name . ' - ' . $planDay->name;
        }

        $workout = Workout::create([
            'user_id' => $user->id,
            'workout_plan_day_id' => $planDay ? $planDay->id : null,
            'name' => $name,
            'start_time' => Carbon::now(),
        ]);

        // If following a plan day, pre-populate the workout exercises
        if ($planDay) {
            $planDay->exercises->each(function ($planEx) use ($workout) {
                $workout->exercises()->create([
                    'exercise_id' => $planEx->exercise_id,
                    'order' => $planEx->order,
                    'notes' => $planEx->notes,
                ]);
            });
        }

        return $workout;
    }

    /**
     * Finish a workout session and record final ratings/comments.
     */
    public function finishWorkout(Workout $workout, array $data): Workout
    {
        $endTime = Carbon::now();
        $startTime = Carbon::parse($workout->start_time);
        $duration = $startTime->diffInMinutes($endTime);

        $workout->update([
            'end_time' => $endTime,
            'duration_minutes' => $duration,
            'difficulty_rating' => $data['difficulty_rating'] ?? null,
            'athlete_comments' => $data['athlete_comments'] ?? null,
        ]);

        return $workout;
    }
}
