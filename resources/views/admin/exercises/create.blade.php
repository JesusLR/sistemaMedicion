<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Crear Ejercicio') }}
            </h2>
            <a href="{{ route('admin.exercises.index') }}" class="btn btn-secondary btn-sm">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.exercises.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="name" class="form-label font-medium">Nombre del Ejercicio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Ej. Press de Banca Inclinado">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo de Ejercicio -->
                            <div class="col-md-6">
                                <label for="exercise_type" class="form-label font-medium">Tipo de Ejercicio <span class="text-danger">*</span></label>
                                <select class="form-select @error('exercise_type') is-invalid @enderror" id="exercise_type" name="exercise_type" required>
                                    <option value="" disabled selected>Selecciona tipo...</option>
                                    <option value="Fuerza" {{ old('exercise_type') == 'Fuerza' ? 'selected' : '' }}>Fuerza / Compuesto</option>
                                    <option value="Aislamiento" {{ old('exercise_type') == 'Aislamiento' ? 'selected' : '' }}>Aislamiento</option>
                                    <option value="Cardio" {{ old('exercise_type') == 'Cardio' ? 'selected' : '' }}>Cardio</option>
                                </select>
                                @error('exercise_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Grupo Muscular -->
                            <div class="col-md-4">
                                <label for="muscle_group" class="form-label font-medium">Grupo Muscular <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('muscle_group') is-invalid @enderror" id="muscle_group" name="muscle_group" value="{{ old('muscle_group') }}" required placeholder="Ej. Pecho, Piernas, Espalda">
                                @error('muscle_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Músculo Principal -->
                            <div class="col-md-4">
                                <label for="primary_muscle" class="form-label font-medium">Músculo Principal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('primary_muscle') is-invalid @enderror" id="primary_muscle" name="primary_muscle" value="{{ old('primary_muscle') }}" required placeholder="Ej. Pectoral Mayor, Cuádriceps">
                                @error('primary_muscle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dificultad -->
                            <div class="col-md-4">
                                <label for="difficulty" class="form-label font-medium">Dificultad <span class="text-danger">*</span></label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                                    <option value="" disabled selected>Selecciona dificultad...</option>
                                    <option value="Principiante" {{ old('difficulty') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                                    <option value="Intermedio" {{ old('difficulty') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                    <option value="Avanzado" {{ old('difficulty') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Equipo -->
                            <div class="col-md-6">
                                <label for="equipment" class="form-label font-medium">Equipo Requerido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('equipment') is-invalid @enderror" id="equipment" name="equipment" value="{{ old('equipment') }}" required placeholder="Ej. Barra, Mancuernas, Cable, Peso Corporal">
                                @error('equipment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Estado Activo -->
                            <div class="col-md-6 d-flex align-items-end pb-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label font-medium" for="is_active">Ejercicio Activo</label>
                                </div>
                            </div>

                            <!-- Músculos Secundarios (Dinámico) -->
                            <div class="col-12">
                                <label class="form-label font-medium">Músculos Secundarios</label>
                                <div id="secondary-muscles-wrapper" class="d-flex flex-column gap-2 mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text" name="secondary_muscles[]" class="form-control" placeholder="Ej. Deltoides anterior">
                                        <button type="button" class="btn btn-outline-danger btn-remove-muscle" style="display:none;">&times;</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-add-muscle">
                                    + Agregar Músculo Secundario
                                </button>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label for="description" class="form-label font-medium">Descripción Breve</label>
                                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Describe brevemente el propósito del ejercicio...">{{ old('description') }}</textarea>
                            </div>

                            <!-- Instrucciones -->
                            <div class="col-12">
                                <label for="instructions" class="form-label font-medium">Instrucciones de Ejecución</label>
                                <textarea class="form-control" id="instructions" name="instructions" rows="4" placeholder="1. Coloca los pies...&#10;2. Baja la barra...&#10;3. Empuja con fuerza...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success px-4">
                                Guardar Ejercicio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS para interactividad dinámica en músculos secundarios -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('secondary-muscles-wrapper');
            const btnAdd = document.getElementById('btn-add-muscle');

            // Agregar nuevo campo
            btnAdd.addEventListener('click', function() {
                const div = document.createElement('div');
                div.className = 'd-flex gap-2 align-items-center';
                div.innerHTML = `
                    <input type="text" name="secondary_muscles[]" class="form-control" placeholder="Ej. Tríceps">
                    <button type="button" class="btn btn-outline-danger btn-remove-muscle">&times;</button>
                `;
                wrapper.appendChild(div);
                updateRemoveButtons();
            });

            // Manejar click en borrar
            wrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-muscle')) {
                    e.target.closest('div').remove();
                    updateRemoveButtons();
                }
            });

            function updateRemoveButtons() {
                const rows = wrapper.children;
                const buttons = wrapper.querySelectorAll('.btn-remove-muscle');
                if (rows.length <= 1) {
                    buttons.forEach(btn => btn.style.display = 'none');
                } else {
                    buttons.forEach(btn => btn.style.display = 'block');
                }
            }
        });
    </script>
</x-app-layout>
