<?php

namespace App\Http\Controllers\Athlete;

use App\Http\Controllers\Controller;
use App\Models\WorkoutExercise;
use App\Models\WorkoutSet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WorkoutSetController extends Controller
{
    /**
     * Store a new set for a workout exercise via AJAX.
     */
    public function store(Request $request, WorkoutExercise $workoutExercise): JsonResponse
    {
        $workout = $workoutExercise->workout;
        
        // Ensure the athlete owns this workout session
        if ($workout->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
        }

        $request->validate([
            'weight' => ['required', 'numeric', 'min:0'],
            'reps' => ['required', 'integer', 'min:0'],
            'rir' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'rpe' => ['nullable', 'numeric', 'min:1', 'max:10'],
            'rest_actual_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $nextSetNumber = $workoutExercise->sets()->count() + 1;

        $set = $workoutExercise->sets()->create([
            'set_number' => $nextSetNumber,
            'weight' => $request->weight,
            'reps' => $request->reps,
            'rir' => $request->rir,
            'rpe' => $request->rpe,
            'rest_actual_seconds' => $request->rest_actual_seconds,
            'is_completed' => true,
        ]);

        return response()->json([
            'success' => true,
            'set' => $set,
        ]);
    }

    /**
     * Delete a set from a workout exercise via AJAX.
     */
    public function destroy(WorkoutSet $set): JsonResponse
    {
        $workoutExercise = $set->workoutExercise;
        $workout = $workoutExercise->workout;

        // Ensure the athlete owns this workout session
        if ($workout->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
        }

        $set->delete();

        // Re-index remaining sets for this exercise
        $sets = $workoutExercise->sets()->orderBy('set_number')->get();
        foreach ($sets as $index => $s) {
            $s->update(['set_number' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'remaining_sets' => $sets,
        ]);
    }
}
