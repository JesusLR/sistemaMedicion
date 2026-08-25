<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkoutPlan;

class WorkoutPlanPolicy
{
    /**
     * Determine if the user can view the plan.
     */
    public function view(User $user, WorkoutPlan $plan): bool
    {
        // Creator can view
        if ($plan->creator_id === $user->id) {
            return true;
        }

        // Admin can view
        if ($user->isAdmin()) {
            return true;
        }

        // Assigned athletes can view
        if ($user->isAthlete()) {
            // Check if the plan creator is the trainer of this athlete
            return $plan->creator->athletes()->where('athlete_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can update the plan.
     */
    public function update(User $user, WorkoutPlan $plan): bool
    {
        // Only creator or admin can update
        return $plan->creator_id === $user->id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the plan.
     */
    public function delete(User $user, WorkoutPlan $plan): bool
    {
        // Only creator or admin can delete
        return $plan->creator_id === $user->id || $user->isAdmin();
    }
}
