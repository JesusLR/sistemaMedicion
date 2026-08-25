<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Detalles del Plan: ') }} {{ $plan->name }}
            </h2>
            <div>
                <a href="{{ route('trainer.plans.edit', $plan) }}" class="btn btn-warning btn-sm">
                    Editar Detalles
                </a>
                <a href="{{ route('trainer.plans.index') }}" class="btn btn-secondary btn-sm ms-2">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Info General -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <p class="text-gray-600 mb-2"><strong>Objetivo:</strong> {{ $plan->goal ?: 'General' }} | <strong>Dificultad:</strong> {{ $plan->difficulty ?: 'Cualquiera' }}</p>
                    <p class="text-gray-700 m-0">{{ $plan->description ?: 'Sin descripción adicional.' }}</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Seccion de dias -->
                <div class="col-lg-8">
                    <h3 class="font-semibold text-lg mb-3">Días de Entrenamiento</h3>
                    
                    @forelse($plan->days as $day)
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center border-0 py-3">
                                <h4 class="font-bold text-base m-0 text-indigo-700">
                                    Día {{ $day->day_number }}: {{ $day->name }}
                                </h4>
                                <form action="{{ route('trainer.plans.days.destroy', $day) }}" method="POST" onsubmit="return confirm('¿Borrar este día de la rutina? Se eliminarán los ejercicios asociados.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-xs py-1">
                                        Eliminar Día
                                    </button>
                                </form>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light text-xs uppercase text-gray-500">
                                            <tr>
                                                <th class="ps-3" style="width: 5%;">#</th>
                                                <th style="width: 25%;">Ejercicio</th>
                                                <th style="width: 10%;">Series</th>
                                                <th style="width: 10%;">Reps</th>
                                                <th style="width: 12%;">Objetivos</th>
                                                <th style="width: 15%;">Descanso/Tempo</th>
                                                <th>Notas</th>
                                                <th class="text-end pe-3" style="width: 8%;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($day->exercises as $dayEx)
                                                <tr>
                                                    <td class="ps-3 font-bold text-gray-400">{{ $dayEx->order }}</td>
                                                    <td class="font-semibold text-gray-900">
                                                        {{ $dayEx->exercise->name }}
                                                    </td>
                                                    <td>{{ $dayEx->target_sets }}</td>
                                                    <td>{{ $dayEx->target_reps }}</td>
                                                    <td>
                                                        <div class="text-xs">
                                                            @if($dayEx->target_weight) <span>{{ $dayEx->target_weight }} kg</span><br>@endif
                                                            @if($dayEx->target_rir) <span>RIR {{ $dayEx->target_rir }}</span><br>@endif
                                                            @if($dayEx->target_rpe) <span>RPE {{ $dayEx->target_rpe }}</span>@endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-xs">
                                                            @if($dayEx->rest_time_seconds) <span>Descanso: {{ $dayEx->rest_time_seconds }}s</span><br>@endif
                                                            @if($dayEx->tempo) <span>Tempo: {{ $dayEx->tempo }}</span>@endif
                                                        </div>
                                                    </td>
                                                    <td class="text-xs text-gray-500">{{ $dayEx->notes }}</td>
                                                    <td class="text-end pe-3">
                                                        <form action="{{ route('trainer.plans.exercises.destroy', $dayEx) }}" method="POST" onsubmit="return confirm('¿Quitar este ejercicio del día?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-xs py-0 px-1" title="Quitar">
                                                                Quitar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4 text-gray-400 text-sm italic">
                                                        Sin ejercicios agregados para este día.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Formulario para agregar ejercicio a este día -->
                            <div class="card-footer bg-light/30 border-0 p-3">
                                <h5 class="font-semibold text-xs uppercase text-gray-500 mb-2">+ Agregar Ejercicio</h5>
                                <form action="{{ route('trainer.plans.days.exercises.store', $day) }}" method="POST">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <select class="form-select form-select-sm" name="exercise_id" required>
                                                <option value="" disabled selected>Selecciona ejercicio...</option>
                                                @foreach($exercises as $ex)
                                                    <option value="{{ $ex->id }}">{{ $ex->name }} ({{ $ex->muscle_group }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-md-1">
                                            <input type="number" class="form-control form-select-sm form-control-sm" name="target_sets" placeholder="Series" required min="1">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <input type="text" class="form-control form-control-sm" name="target_reps" placeholder="Reps (ej. 8-12)" required>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <input type="number" step="0.5" class="form-control form-control-sm" name="target_weight" placeholder="Peso (kg)">
                                        </div>
                                        <div class="col-6 col-md-1">
                                            <input type="number" step="0.5" class="form-control form-control-sm" name="target_rir" placeholder="RIR">
                                        </div>
                                        <div class="col-6 col-md-1">
                                            <input type="number" step="0.5" class="form-control form-control-sm" name="target_rpe" placeholder="RPE">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <input type="number" class="form-control form-control-sm" name="rest_time_seconds" placeholder="Descanso (s)">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <input type="text" class="form-control form-control-sm" name="tempo" placeholder="Tempo (ej. 4010)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="notes" placeholder="Notas/Instrucciones de la serie">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-sm w-100 py-1">Agregar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm border-0 text-center py-4">
                            <div class="card-body text-gray-500 italic">
                                Aún no has agregado días de entrenamiento a este plan.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Formulario Agregar Dia -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4 sticky-top" style="top: 2rem;">
                        <div class="card-body">
                            <h3 class="font-semibold text-lg mb-3">Agregar Día de Rutina</h3>
                            <form action="{{ route('trainer.plans.days.store', $plan) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="day_name" class="form-label font-medium">Nombre del Día</label>
                                    <input type="text" class="form-control" id="day_name" name="name" required placeholder="Ej. Empuje / Tren Superior / Día A">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    + Agregar Día
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
