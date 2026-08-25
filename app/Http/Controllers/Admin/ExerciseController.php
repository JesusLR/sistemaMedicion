<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $exercises = Exercise::orderBy('name')->get();
        return view('admin.exercises.index', compact('exercises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.exercises.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');
        $data['secondary_muscles'] = $request->secondary_muscles ?? [];

        Exercise::create($data);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Ejercicio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise): View
    {
        return view('admin.exercises.show', compact('exercise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise): View
    {
        return view('admin.exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreExerciseRequest $request, Exercise $exercise): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');
        $data['secondary_muscles'] = $request->secondary_muscles ?? [];

        $exercise->update($data);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Ejercicio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise): RedirectResponse
    {
        // For safety, let's use logical deactivation instead of hard delete if it has references,
        // or just delete it if the DB allows.
        try {
            $exercise->delete();
            return redirect()->route('admin.exercises.index')
                ->with('success', 'Ejercicio eliminado exitosamente.');
        } catch (\Exception $e) {
            // If it has references (workout plans, etc.) it will fail because of RESTRICT constraint.
            // We deactivate it instead.
            $exercise->update(['is_active' => false]);
            return redirect()->route('admin.exercises.index')
                ->with('warning', 'El ejercicio no se pudo eliminar porque ya está en uso. Ha sido desactivado.');
        }
    }
}
