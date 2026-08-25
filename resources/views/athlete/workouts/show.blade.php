<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                Resumen de Entrenamiento: {{ $workout->name }}
            </h2>
            <a href="{{ route('athlete.workouts.index') }}" class="btn btn-secondary btn-sm">
                Volver al Historial
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container max-w-4xl">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tarjeta resumen superior -->
            <div class="card shadow-sm border-0 mb-4 bg-gradient-to-r from-success-subtle to-info-subtle">
                <div class="card-body p-4">
                    <div class="row g-3 text-center text-md-start">
                        <div class="col-md-3">
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Fecha</span>
                            <span class="font-bold text-lg text-gray-800">{{ $workout->start_time->format('d/m/Y') }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Duración</span>
                            <span class="font-bold text-lg text-gray-800">{{ $workout->duration_minutes ?: '0' }} minutos</span>
                        </div>
                        <div class="col-md-3">
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Esfuerzo</span>
                            <span class="badge bg-success-subtle text-success-emphasis text-sm font-bold">
                                {{ $workout->difficulty_rating }}/10
                            </span>
                        </div>
                        <div class="col-md-3">
                            <span class="block text-xs font-semibold text-gray-400 uppercase">Hora</span>
                            <span class="font-bold text-lg text-gray-800">{{ $workout->start_time->format('H:i') }} - {{ $workout->end_time ? $workout->end_time->format('H:i') : '' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ejercicios Realizados -->
            <h3 class="font-bold text-lg mb-3">Detalle del Entrenamiento</h3>
            @forelse($workout->exercises as $workEx)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light py-3 border-0">
                        <h4 class="font-bold text-base m-0 text-gray-900">
                            {{ $workEx->exercise->name }}
                        </h4>
                        <span class="text-xs text-gray-500">{{ $workEx->exercise->muscle_group }}</span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table align-middle mb-0">
                            <thead class="table-light text-xs text-gray-400 uppercase">
                                <tr>
                                    <th class="ps-3" style="width: 15%;">Serie</th>
                                    <th style="width: 30%;">Carga</th>
                                    <th style="width: 30%;">Repeticiones</th>
                                    <th style="width: 25%;">Percepción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workEx->sets as $set)
                                    <tr>
                                        <td class="ps-3 font-bold text-gray-400">{{ $set->set_number }}</td>
                                        <td class="font-semibold">{{ floatval($set->weight) }} kg</td>
                                        <td>{{ $set->reps }} reps</td>
                                        <td>
                                            <div class="text-xs text-gray-600">
                                                @if($set->rir !== null) <span class="badge bg-secondary-subtle text-secondary-emphasis">RIR {{ floatval($set->rir) }}</span> @endif
                                                @if($set->rpe !== null) <span class="badge bg-warning-subtle text-warning-emphasis">RPE {{ floatval($set->rpe) }}</span> @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-sm text-gray-400 italic">
                                            Sin series registradas en este ejercicio.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body text-gray-500">No se registraron ejercicios en esta sesión.</div>
                </div>
            @endforelse

            <!-- Comentarios -->
            @if($workout->athlete_comments || $workout->trainer_comments)
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h4 class="font-bold text-base border-b pb-2 mb-3">Comentarios</h4>
                        
                        @if($workout->athlete_comments)
                            <div class="mb-3">
                                <span class="block text-xs font-semibold text-gray-400 uppercase">Atleta</span>
                                <p class="text-gray-700 italic m-0">"{{ $workout->athlete_comments }}"</p>
                            </div>
                        @endif

                        @if($workout->trainer_comments)
                            <div class="border-t pt-3">
                                <span class="block text-xs font-semibold text-gray-400 uppercase">Entrenador (Feedback)</span>
                                <p class="text-gray-700 italic m-0">"{{ $workout->trainer_comments }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
