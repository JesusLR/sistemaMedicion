<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Iniciar Entrenamiento') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container max-w-4xl">
            @if(session('warning'))
                <div class="alert alert-warning mb-4">{{ session('warning') }}</div>
            @endif

            @if($activeWorkout)
                <div class="card border-warning shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <h3 class="font-bold text-lg text-amber-700 mb-2">¡Tienes un entrenamiento activo!</h3>
                        <p class="text-sm text-gray-600 mb-3">Tienes una sesión iniciada el {{ $activeWorkout->start_time->format('d/m/Y H:i') }}.</p>
                        <a href="{{ route('athlete.workouts.edit', $activeWorkout) }}" class="btn btn-warning px-4 py-2">
                            Regresar al Entrenamiento Activo
                        </a>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    <!-- Entrenamiento Libre -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column p-4">
                                <h3 class="font-bold text-lg mb-2">Entrenamiento Libre</h3>
                                <p class="text-sm text-gray-600 mb-4 flex-grow-1">Inicia una sesión vacía para registrar ejercicios y series de forma libre, ideal para días de improvisación o rutinas rápidas.</p>
                                <form action="{{ route('athlete.workouts.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="custom_name" placeholder="Nombre opcional (ej. Cardio y Core)">
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 py-2">
                                        Iniciar Sesión Libre
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Rutinas Asignadas -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <h3 class="font-bold text-lg mb-3">Seguir una Rutina</h3>
                                <p class="text-sm text-gray-600 mb-4">Selecciona un día de tus rutinas planificadas para cargar automáticamente la lista de ejercicios objetivos.</p>

                                @forelse($plans as $plan)
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-sm border-b pb-1 text-indigo-600 mb-2">{{ $plan->name }}</h4>
                                        <div class="d-grid gap-2">
                                            @foreach($plan->days as $day)
                                                <form action="{{ route('athlete.workouts.store') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="workout_plan_day_id" value="{{ $day->id }}">
                                                    <button type="submit" class="btn btn-outline-primary text-start w-100 py-2 d-flex justify-content-between align-items-center">
                                                        <span>Día {{ $day->day_number }}: {{ $day->name }}</span>
                                                        <span class="badge bg-primary-subtle text-primary-emphasis text-xs">
                                                            {{ $day->exercises->count() }} Ejercicios
                                                        </span>
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic">No tienes rutinas asignadas o creadas en este momento.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
