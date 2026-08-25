<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Editar Plan: ') }} {{ $plan->name }}
            </h2>
            <a href="{{ route('trainer.plans.show', $plan) }}" class="btn btn-secondary btn-sm">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0 max-w-2xl mx-auto">
                <div class="card-body p-4">
                    <form action="{{ route('trainer.plans.update', $plan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label font-medium">Nombre del Plan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $plan->name) }}" required placeholder="Ej. Rutina de Fuerza 5x5">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="goal" class="form-label font-medium">Objetivo</label>
                                <input type="text" class="form-control @error('goal') is-invalid @enderror" id="goal" name="goal" value="{{ old('goal', $plan->goal) }}" placeholder="Ej. Hipertrofia, Fuerza">
                                @error('goal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="difficulty" class="form-label font-medium">Nivel de Dificultad</label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty">
                                    <option value="" selected>Selecciona nivel...</option>
                                    <option value="Principiante" {{ old('difficulty', $plan->difficulty) == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                                    <option value="Intermedio" {{ old('difficulty', $plan->difficulty) == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                    <option value="Avanzado" {{ old('difficulty', $plan->difficulty) == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label font-medium">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe la rutina...">{{ old('description', $plan->description) }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">
                                Actualizar Detalles
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
