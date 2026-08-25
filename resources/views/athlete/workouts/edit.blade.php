<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                🏋️ Entrenamiento Activo: {{ $workout->name }}
            </h2>
            <form action="{{ route('athlete.workouts.destroy', $workout) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar este entrenamiento? Se borrarán todos los registros de esta sesión.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    Cancelar Sesión
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container max-w-5xl">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Zona de Ejercicios y registro de series -->
                <div class="col-lg-8">
                    @forelse($workout->exercises as $workEx)
                        <div class="card shadow-sm border-0 mb-4 exercise-card" id="exercise-card-{{ $workEx->id }}">
                            <div class="card-header bg-light py-3 border-0">
                                <h3 class="font-bold text-base m-0 text-gray-900">
                                    {{ $workEx->exercise->name }}
                                </h3>
                                <span class="text-xs text-gray-500">{{ $workEx->exercise->muscle_group }} | {{ $workEx->exercise->equipment }}</span>
                            </div>
                            <div class="card-body p-0">
                                <table class="table align-middle mb-0" id="set-table-{{ $workEx->id }}">
                                    <thead class="table-light text-xs text-gray-500 uppercase">
                                        <tr>
                                            <th class="ps-3" style="width: 10%;">Serie</th>
                                            <th style="width: 25%;">Peso (kg)</th>
                                            <th style="width: 20%;">Reps</th>
                                            <th style="width: 15%;">RIR</th>
                                            <th style="width: 15%;">RPE</th>
                                            <th class="text-end pe-3" style="width: 15%;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="set-rows-{{ $workEx->id }}">
                                        @forelse($workEx->sets as $set)
                                            <tr id="set-row-{{ $set->id }}">
                                                <td class="ps-3 font-bold text-gray-400 set-number">{{ $set->set_number }}</td>
                                                <td><span class="font-semibold">{{ floatval($set->weight) }}</span> kg</td>
                                                <td>{{ $set->reps }} reps</td>
                                                <td>{{ $set->rir !== null ? 'RIR ' . floatval($set->rir) : '-' }}</td>
                                                <td>{{ $set->rpe !== null ? 'RPE ' . floatval($set->rpe) : '-' }}</td>
                                                <td class="text-end pe-3">
                                                    <button type="button" class="btn btn-link text-danger p-0 text-xs text-decoration-none btn-delete-set" data-set-id="{{ $set->id }}">
                                                        Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="no-sets-placeholder">
                                                <td colspan="6" class="text-center py-3 text-sm text-gray-400 italic">
                                                    Sin series registradas todavía.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Panel agregar serie -->
                            <div class="card-footer bg-light/30 border-0 p-3">
                                <form class="form-add-set" data-workout-exercise-id="{{ $workEx->id }}">
                                    <div class="row g-2">
                                        <div class="col-4 col-md-3">
                                            <input type="number" step="0.25" class="form-control form-control-sm input-weight" required min="0" placeholder="Peso (kg)">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <input type="number" class="form-control form-control-sm input-reps" required min="0" placeholder="Reps">
                                        </div>
                                        <div class="col-2 col-md-2">
                                            <input type="number" step="0.5" class="form-control form-control-sm input-rir" min="0" max="10" placeholder="RIR">
                                        </div>
                                        <div class="col-2 col-md-2">
                                            <input type="number" step="0.5" class="form-control form-control-sm input-rpe" min="1" max="10" placeholder="RPE">
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary btn-sm w-100 py-1 font-semibold">
                                                + Guardar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm border-0 text-center py-5">
                            <div class="card-body">
                                <p class="text-gray-500 mb-3">No tienes ejercicios agregados a este entrenamiento.</p>
                                <p class="text-xs text-gray-400 mb-4">Usa la barra lateral para agregar ejercicios.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Barra lateral de finalización y agregar ejercicio -->
                <div class="col-lg-4">
                    <!-- Agregar Ejercicio Ad-hoc -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h3 class="font-bold text-base mb-3">Agregar Ejercicio</h3>
                            <form action="{{ route('athlete.workouts.add-exercise', $workout) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <select class="form-select" name="exercise_id" required>
                                        <option value="" disabled selected>Selecciona ejercicio...</option>
                                        @foreach($exercises as $ex)
                                            <option value="{{ $ex->id }}">{{ $ex->name }} ({{ $ex->muscle_group }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                    + Agregar al Entrenamiento
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Finalizar Sesión -->
                    <div class="card shadow-sm border-0 sticky-top" style="top: 2rem;">
                        <div class="card-body">
                            <h3 class="font-bold text-base mb-3 text-success">Finalizar Entrenamiento</h3>
                            <form action="{{ route('athlete.workouts.update', $workout) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Dificultad Percibida -->
                                <div class="mb-3">
                                    <label for="difficulty_rating" class="form-label font-semibold text-xs text-gray-500 uppercase">Esfuerzo Percibido (1-10) <span class="text-danger">*</span></label>
                                    <select class="form-select" name="difficulty_rating" id="difficulty_rating" required>
                                        <option value="" disabled selected>Elige dificultad percibida...</option>
                                        <option value="1">1 - Extremadamente Fácil</option>
                                        <option value="2">2 - Muy Fácil</option>
                                        <option value="3">3 - Fácil</option>
                                        <option value="4">4 - Moderado</option>
                                        <option value="5">5 - Un Poco Duro</option>
                                        <option value="6">6 - Duro</option>
                                        <option value="7">7 - Muy Duro</option>
                                        <option value="8">8 - Extremadamente Duro</option>
                                        <option value="9">9 - Cerca del Límite</option>
                                        <option value="10">10 - Esfuerzo Máximo</option>
                                    </select>
                                </div>

                                <!-- Comentarios -->
                                <div class="mb-4">
                                    <label for="athlete_comments" class="form-label font-semibold text-xs text-gray-500 uppercase">Comentarios y Sensaciones</label>
                                    <textarea class="form-control" name="athlete_comments" id="athlete_comments" rows="3" placeholder="¿Cómo te sentiste hoy? Ej. Buen pump, me dolió el hombro..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-success w-100 py-2 font-bold">
                                    Terminar y Guardar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AJAX LOGIC FOR WORKOUT SETS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // interceptar el envío de los formularios de agregar serie
            document.querySelectorAll('.form-add-set').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const workExId = this.dataset.workoutExerciseId;
                    const weight = this.querySelector('.input-weight').value;
                    const reps = this.querySelector('.input-reps').value;
                    const rir = this.querySelector('.input-rir').value;
                    const rpe = this.querySelector('.input-rpe').value;
                    
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Enviando...';

                    // Petición fetch
                    fetch(`/workout-exercises/${workExId}/sets`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            weight: weight,
                            reps: reps,
                            rir: rir || null,
                            rpe: rpe || null
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = '+ Guardar';

                        if(data.success) {
                            // Limpiar inputs
                            this.querySelector('.input-weight').value = '';
                            this.querySelector('.input-reps').value = '';
                            this.querySelector('.input-rir').value = '';
                            this.querySelector('.input-rpe').value = '';

                            // Quitar placeholder de "sin series" si existe
                            const tbody = document.getElementById(`set-rows-${workExId}`);
                            const placeholder = tbody.querySelector('.no-sets-placeholder');
                            if(placeholder) {
                                placeholder.remove();
                            }

                            // Construir y anexar fila de forma dinámica
                            const set = data.set;
                            const rirText = set.rir !== null ? 'RIR ' + parseFloat(set.rir) : '-';
                            const rpeText = set.rpe !== null ? 'RPE ' + parseFloat(set.rpe) : '-';

                            const tr = document.createElement('tr');
                            tr.id = `set-row-${set.id}`;
                            tr.innerHTML = `
                                <td class="ps-3 font-bold text-gray-400 set-number">${set.set_number}</td>
                                <td><span class="font-semibold">${parseFloat(set.weight)}</span> kg</td>
                                <td>${set.reps} reps</td>
                                <td>${rirText}</td>
                                <td>${rpeText}</td>
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-link text-danger p-0 text-xs text-decoration-none btn-delete-set" data-set-id="${set.id}">
                                        Eliminar
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        } else {
                            alert('Error al guardar: ' + (data.error || 'datos inválidos.'));
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = '+ Guardar';
                        console.error('Error:', error);
                        alert('Error de conexión.');
                    });
                });
            });

            // Escuchar clicks de eliminación en el cuerpo de las tablas (delegación de eventos)
            document.querySelectorAll('tbody').forEach(tbody => {
                tbody.addEventListener('click', function(e) {
                    if (e.target.classList.contains('btn-delete-set')) {
                        const setId = e.target.dataset.setId;
                        const row = document.getElementById(`set-row-${setId}`);
                        const tbodyContainer = this;

                        if (confirm('¿Quieres eliminar esta serie?')) {
                            e.target.disabled = true;

                            fetch(`/workout-sets/${setId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    row.remove();
                                    
                                    // Re-numerar las series restantes en el DOM
                                    const rows = tbodyContainer.querySelectorAll('tr:not(.no-sets-placeholder)');
                                    if (rows.length === 0) {
                                        tbodyContainer.innerHTML = `
                                            <tr class="no-sets-placeholder">
                                                <td colspan="6" class="text-center py-3 text-sm text-gray-400 italic">
                                                    Sin series registradas todavía.
                                                </td>
                                            </tr>
                                        `;
                                    } else {
                                        rows.forEach((r, idx) => {
                                            r.querySelector('.set-number').textContent = idx + 1;
                                        });
                                    }
                                } else {
                                    alert('No se pudo borrar la serie.');
                                }
                            })
                            .catch(error => {
                                e.target.disabled = false;
                                console.error('Error:', error);
                                alert('Error de conexión.');
                            });
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
