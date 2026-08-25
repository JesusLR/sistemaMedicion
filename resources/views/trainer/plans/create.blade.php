<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Nuevo Plan de Entrenamiento') }}
            </h2>
            <a href="{{ route('trainer.plans.index') }}" class="btn btn-secondary btn-sm">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0 max-w-2xl mx-auto">
                <div class="card-body p-4">
                    <form action="{{ route('trainer.plans.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label font-medium">Nombre del Plan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Ej. Rutina de Fuerza 5x5">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="goal" class="form-label font-medium">Objetivo</label>
                                <input type="text" class="form-control @error('goal') is-invalid @enderror" id="goal" name="goal" value="{{ old('goal') }}" placeholder="Ej. Hipertrofia, Fuerza">
                                @error('goal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="difficulty" class="form-label font-medium">Nivel de Dificultad</label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty">
                                    <option value="" selected>Selecciona nivel...</option>
                                    <option value="Principiante" {{ old('difficulty') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                                    <option value="Intermedio" {{ old('difficulty') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                    <option value="Avanzado" {{ old('difficulty') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label font-medium">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe brevemente en qué consiste la rutina, número sugerido de semanas, etc...">{{ old('description') }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">
                                Guardar y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
