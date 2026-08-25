<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ $exercise->name }}
            </h2>
            <div>
                <a href="{{ route('admin.exercises.edit', $exercise) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>
                <a href="{{ route('admin.exercises.index') }}" class="btn btn-secondary btn-sm ms-2">
                    Volver al Listado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row g-4">
                <!-- Info principal -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 mb-4 h-100">
                        <div class="card-body">
                            <h4 class="font-semibold border-b pb-2 mb-3">Clasificación</h4>
                            
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Grupo Muscular:</span>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $exercise->muscle_group }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Músculo Principal:</span>
                                    <span class="font-medium">{{ $exercise->primary_muscle }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Músculos Secundarios:</span>
                                    <div>
                                        @php
                                            $secMuscles = is_array($exercise->secondary_muscles) ? $exercise->secondary_muscles : [];
                                        @endphp
                                        @forelse($secMuscles as $m)
                                            <span class="badge bg-light text-dark border me-1">{{ $m }}</span>
                                        @empty
                                            <span class="text-muted text-sm">Ninguno</span>
                                        @endforelse
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Tipo:</span>
                                    <span>{{ $exercise->exercise_type }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Equipo:</span>
                                    <span>{{ $exercise->equipment }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Dificultad:</span>
                                    <span class="badge bg-info-subtle text-info-emphasis">{{ $exercise->difficulty }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Estado:</span>
                                    @if($exercise->is_active)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Detalles de Texto -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h4 class="font-semibold border-b pb-2 mb-3">Descripción</h4>
                            <p class="text-gray-700 mb-4">
                                {{ $exercise->description ?: 'Sin descripción registrada.' }}
                            </p>

                            <h4 class="font-semibold border-b pb-2 mb-3">Instrucciones de Ejecución</h4>
                            <div class="text-gray-700 style-instructions">
                                @if($exercise->instructions)
                                    {!! nl2br(e($exercise->instructions)) !!}
                                @else
                                    <p class="text-muted italic">Sin instrucciones especificadas.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
