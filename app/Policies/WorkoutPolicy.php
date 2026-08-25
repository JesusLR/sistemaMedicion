<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workout;

class WorkoutPolicy
{
    /**
     * Determine if the user can view the workout.
     */
    public function view(User $user, Workout $workout): bool
    {
        // Owner can view
        if ($workout->user_id === $user->id) {
            return true;
        }

        // Admin can view
        if ($user->isAdmin()) {
            return true;
        }

        // Assigned trainer can view
        if ($user->isTrainer()) {
            return $user->athletes()->where('athlete_id', $workout->user_id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can update the workout.
     */
    public function update(User $user, Workout $workout): bool
    {
        // Only owner can update (register sets or comments)
        return $workout->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the workout.
     */
    public function delete(User $user, Workout $workout): bool
    {
        // Only owner can delete (cancel session)
        return $workout->user_id === $user->id;
    }
}
