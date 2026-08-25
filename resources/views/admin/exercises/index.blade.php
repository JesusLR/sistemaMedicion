<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Catálogo de Ejercicios') }}
            </h2>
            <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary btn-sm">
                + Nuevo Ejercicio
            </a>
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

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nombre</th>
                                    <th>Grupo Muscular</th>
                                    <th>Músculo Principal</th>
                                    <th>Tipo</th>
                                    <th>Equipo</th>
                                    <th>Dificultad</th>
                                    <th>Estado</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exercises as $exercise)
                                    <tr>
                                        <td class="ps-4 font-semibold text-gray-900">
                                            {{ $exercise->name }}
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis">
                                                {{ $exercise->muscle_group }}
                                            </span>
                                        </td>
                                        <td>{{ $exercise->primary_muscle }}</td>
                                        <td>{{ $exercise->exercise_type }}</td>
                                        <td>{{ $exercise->equipment }}</td>
                                        <td>
                                            @php
                                                $diffColor = match($exercise->difficulty) {
                                                    'Principiante' => 'bg-success-subtle text-success-emphasis',
                                                    'Intermedio' => 'bg-warning-subtle text-warning-emphasis',
                                                    'Avanzado' => 'bg-danger-subtle text-danger-emphasis',
                                                    default => 'bg-secondary-subtle text-secondary-emphasis'
                                                };
                                            @endphp
                                            <span class="badge {{ $diffColor }}">
                                                {{ $exercise->difficulty }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($exercise->is_active)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.exercises.show', $exercise) }}" class="btn btn-outline-info btn-xs" title="Ver Detalle">
                                                    Ver
                                                </a>
                                                <a href="{{ route('admin.exercises.edit', $exercise) }}" class="btn btn-outline-warning btn-xs" title="Editar">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.exercises.destroy', $exercise) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar o desactivar este ejercicio?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-xs" title="Eliminar">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-gray-500">
                                            No hay ejercicios registrados en el catálogo.
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
