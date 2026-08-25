<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Grupo de Atleta
Route::middleware(['auth', 'verified', 'role:athlete'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('workouts', \App\Http\Controllers\Athlete\WorkoutController::class)->names('athlete.workouts');
    Route::post('workouts/{workout}/add-exercise', [\App\Http\Controllers\Athlete\WorkoutController::class, 'addExercise'])->name('athlete.workouts.add-exercise');
    Route::post('workout-exercises/{workoutExercise}/sets', [\App\Http\Controllers\Athlete\WorkoutSetController::class, 'store'])->name('athlete.workouts.sets.store');
    Route::delete('workout-sets/{set}', [\App\Http\Controllers\Athlete\WorkoutSetController::class, 'destroy'])->name('athlete.workouts.sets.destroy');
});

// Grupo de Entrenador
Route::middleware(['auth', 'verified', 'role:trainer,admin'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('trainer.dashboard');
    })->name('dashboard');

    Route::resource('plans', \App\Http\Controllers\Trainer\WorkoutPlanController::class);
    Route::post('plans/{plan}/days', [\App\Http\Controllers\Trainer\WorkoutPlanController::class, 'storeDay'])->name('plans.days.store');
    Route::delete('plans/days/{day}', [\App\Http\Controllers\Trainer\WorkoutPlanController::class, 'destroyDay'])->name('plans.days.destroy');
    Route::post('plans/days/{day}/exercises', [\App\Http\Controllers\Trainer\WorkoutPlanController::class, 'storeExercise'])->name('plans.days.exercises.store');
    Route::delete('plans/exercises/{exercise}', [\App\Http\Controllers\Trainer\WorkoutPlanController::class, 'destroyExercise'])->name('plans.exercises.destroy');
});

// Grupo de Administración
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('exercises', \App\Http\Controllers\Admin\ExerciseController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{athlete}/assign-trainer', [\App\Http\Controllers\Admin\UserController::class, 'assignTrainer'])->name('users.assign-trainer');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
