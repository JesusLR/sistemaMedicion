<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanDay;
use App\Models\WorkoutPlanExercise;
use App\Models\Exercise;
use App\Http\Requests\StoreWorkoutPlanRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkoutPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Trainers see their own plans, admins see all.
        $plansQuery = WorkoutPlan::with('creator');
        if (!auth()->user()->isAdmin()) {
            $plansQuery->where('creator_id', auth()->id());
        }
        $plans = $plansQuery->orderBy('created_at', 'desc')->get();

        return view('trainer.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('trainer.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkoutPlanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['creator_id'] = auth()->id();
        $data['is_active'] = true;

        $plan = WorkoutPlan::create($data);

        return redirect()->route('trainer.plans.show', $plan)
            ->with('success', 'Plan de entrenamiento creado. Ahora agrega los días y ejercicios.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutPlan $plan): View
    {
        // Eager load days and exercises with their target details
        $plan->load('days.exercises.exercise');
        $exercises = Exercise::where('is_active', true)->orderBy('name')->get();

        return view('trainer.plans.show', compact('plan', 'exercises'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutPlan $plan): View
    {
        return view('trainer.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreWorkoutPlanRequest $request, WorkoutPlan $plan): RedirectResponse
    {
        $plan->update($request->validated());

        return redirect()->route('trainer.plans.show', $plan)
            ->with('success', 'Detalles del plan actualizados.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutPlan $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()->route('trainer.plans.index')
            ->with('success', 'Plan de entrenamiento eliminado.');
    }

    /**
     * Add a day to the workout plan.
     */
    public function storeDay(Request $request, WorkoutPlan $plan): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // Get the next day number
        $nextDayNumber = $plan->days()->count() + 1;

        $plan->days()->create([
            'day_number' => $nextDayNumber,
            'name' => $request->name,
        ]);

        return redirect()->route('trainer.plans.show', $plan)
            ->with('success', 'Día agregado al plan.');
    }

    /**
     * Remove a day from the workout plan.
     */
    public function destroyDay(WorkoutPlanDay $day): RedirectResponse
    {
        $plan = $day->plan;
        $day->delete();

        // Re-index remaining days
        $days = $plan->days()->orderBy('day_number')->get();
        foreach ($days as $index => $d) {
            $d->update(['day_number' => $index + 1]);
        }

        return redirect()->route('trainer.plans.show', $plan)
            ->with('success', 'Día eliminado y secuencia reordenada.');
    }

    /**
     * Add an exercise to a plan day.
     */
    public function storeExercise(Request $request, WorkoutPlanDay $day): RedirectResponse
    {
        $request->validate([
            'exercise_id' => ['required', 'exists:exercises,id'],
            'target_sets' => ['required', 'integer', 'min:1'],
            'target_reps' => ['required', 'string', 'max:50'],
            'target_weight' => ['nullable', 'numeric', 'min:0'],
            'target_rir' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'target_rpe' => ['nullable', 'numeric', 'min:1', 'max:10'],
            'rest_time_seconds' => ['nullable', 'integer', 'min:0'],
            'tempo' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string'],
        ]);

        $nextOrder = $day->exercises()->count() + 1;

        $day->exercises()->create([
            'exercise_id' => $request->exercise_id,
            'target_sets' => $request->target_sets,
            'target_reps' => $request->target_reps,
            'target_weight' => $request->target_weight,
            'target_rir' => $request->target_rir,
            'target_rpe' => $request->target_rpe,
            'rest_time_seconds' => $request->rest_time_seconds,
            'tempo' => $request->tempo,
            'order' => $nextOrder,
            'notes' => $request->notes,
        ]);

        return redirect()->route('trainer.plans.show', $day->plan)
            ->with('success', 'Ejercicio agregado al día.');
    }

    /**
     * Remove an exercise from a plan day.
     */
    public function destroyExercise(WorkoutPlanExercise $exercise): RedirectResponse
    {
        $day = $exercise->day;
        $exercise->delete();

        // Re-index remaining exercises in this day
        $exercises = $day->exercises()->orderBy('order')->get();
        foreach ($exercises as $index => $ex) {
            $ex->update(['order' => $index + 1]);
        }

        return redirect()->route('trainer.plans.show', $day->plan)
            ->with('success', 'Ejercicio retirado y orden actualizado.');
    }
}
