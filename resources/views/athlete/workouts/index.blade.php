<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Historial de Entrenamientos') }}
            </h2>
            <a href="{{ route('athlete.workouts.create') }}" class="btn btn-primary btn-sm">
                Iniciar Entrenamiento
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container max-w-4xl">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-xs text-gray-500 uppercase">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Sesión / Rutina</th>
                                    <th>Duración</th>
                                    <th>Esfuerzo</th>
                                    <th>Ejercicios</th>
                                    <th class="text-end pe-4">Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workouts as $workout)
                                    <tr>
                                        <td class="ps-4 font-semibold">
                                            {{ $workout->start_time->format('d/m/Y') }}
                                            <span class="block text-xs text-gray-400 font-normal">
                                                {{ $workout->start_time->format('H:i') }} hs
                                            </span>
                                        </td>
                                        <td class="font-bold text-gray-900">
                                            {{ $workout->name }}
                                        </td>
                                        <td>
                                            <span class="text-sm">
                                                {{ $workout->duration_minutes ?: '0' }} min
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis">
                                                {{ $workout->difficulty_rating }}/10
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary-emphasis">
                                                {{ $workout->exercises->count() }} ejercicios
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('athlete.workouts.show', $workout) }}" class="btn btn-outline-primary btn-xs">
                                                Ver Resumen
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-gray-500 italic">
                                            No tienes entrenamientos registrados en tu historial.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
