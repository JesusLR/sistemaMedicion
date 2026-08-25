<?php

namespace App\Http\Controllers\Athlete;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\WorkoutPlanDay;
use App\Models\Exercise;
use App\Services\WorkoutService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkoutController extends Controller
{
    protected $workoutService;

    public function __construct(WorkoutService $workoutService)
    {
        $this->workoutService = $workoutService;
    }

    /**
     * Display a listing of completed workouts.
     */
    public function index(): View
    {
        $workouts = auth()->user()->workouts()
            ->whereNotNull('end_time')
            ->orderBy('start_time', 'desc')
            ->get();

        return view('athlete.workouts.index', compact('workouts'));
    }

    /**
     * Show selection screen to start a new workout.
     */
    public function create(): View
    {
        // Get all active workout plans to choose a day
        $plans = \App\Models\WorkoutPlan::where('is_active', true)
            ->with('days.exercises.exercise')
            ->get();

        // Also check if they currently have an active workout in progress (end_time is null)
        $activeWorkout = auth()->user()->workouts()->whereNull('end_time')->first();

        return view('athlete.workouts.create', compact('plans', 'activeWorkout'));
    }

    /**
     * Start the workout and redirect to active logger.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if there is already a workout in progress
        $activeWorkout = auth()->user()->workouts()->whereNull('end_time')->first();
        if ($activeWorkout) {
            return redirect()->route('athlete.workouts.edit', $activeWorkout)
                ->with('warning', 'Ya tienes un entrenamiento en progreso. Termina o cancela ese primero.');
        }

        $planDay = null;
        if ($request->has('workout_plan_day_id')) {
            $planDay = WorkoutPlanDay::findOrFail($request->workout_plan_day_id);
        }

        $workout = $this->workoutService->startWorkout(auth()->user(), $planDay, $request->custom_name);

        return redirect()->route('athlete.workouts.edit', $workout);
    }

    /**
     * Show details of a completed workout.
     */
    public function show(Workout $workout): View
    {
        $this->authorize('view', $workout);

        $workout->load('exercises.exercise', 'exercises.sets');

        return view('athlete.workouts.show', compact('workout'));
    }

    /**
     * Show the active workout logger.
     */
    public function edit(Workout $workout): View
    {
        $this->authorize('update', $workout);

        if ($workout->end_time) {
            return redirect()->route('athlete.workouts.show', $workout)
                ->with('warning', 'Este entrenamiento ya ha finalizado.');
        }

        $workout->load('exercises.exercise', 'exercises.sets');
        $exercises = Exercise::where('is_active', true)->orderBy('name')->get();

        return view('athlete.workouts.edit', compact('workout', 'exercises'));
    }

    /**
     * Finish the workout session.
     */
    public function update(Request $request, Workout $workout): RedirectResponse
    {
        $this->authorize('update', $workout);

        $request->validate([
            'difficulty_rating' => ['required', 'integer', 'min:1', 'max:10'],
            'athlete_comments' => ['nullable', 'string'],
        ]);

        $this->workoutService->finishWorkout($workout, $request->only('difficulty_rating', 'athlete_comments'));

        return redirect()->route('athlete.workouts.show', $workout)
            ->with('success', '¡Entrenamiento registrado con éxito! Gran trabajo.');
    }

    /**
     * Add a dynamic exercise to the active workout session.
     */
    public function addExercise(Request $request, Workout $workout): RedirectResponse
    {
        $this->authorize('update', $workout);

        $request->validate([
            'exercise_id' => ['required', 'exists:exercises,id'],
        ]);

        $nextOrder = $workout->exercises()->count() + 1;

        $workout->exercises()->create([
            'exercise_id' => $request->exercise_id,
            'order' => $nextOrder,
        ]);

        return redirect()->route('athlete.workouts.edit', $workout)
            ->with('success', 'Ejercicio agregado al entrenamiento.');
    }

    /**
     * Cancel / Delete an active workout session.
     */
    public function destroy(Workout $workout): RedirectResponse
    {
        $this->authorize('delete', $workout);
        $workout->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Sesión de entrenamiento cancelada.');
    }
}
