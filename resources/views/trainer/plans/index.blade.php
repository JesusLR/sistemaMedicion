<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Planes de Entrenamiento') }}
            </h2>
            <a href="{{ route('trainer.plans.create') }}" class="btn btn-primary btn-sm">
                + Nuevo Plan
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

            <div class="row g-4">
                @forelse($plans as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $plan->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">
                                    <strong>Creador:</strong> {{ $plan->creator->name }}
                                </p>
                                <p class="text-sm text-gray-600 mb-3 flex-grow-1">
                                    {{ Str::limit($plan->description ?: 'Sin descripción registrada.', 100) }}
                                </p>
                                
                                <div class="mb-3">
                                    @if($plan->goal)
                                        <span class="badge bg-primary-subtle text-primary-emphasis me-1">{{ $plan->goal }}</span>
                                    @endif
                                    @if($plan->difficulty)
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $plan->difficulty }}</span>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center border-t pt-3">
                                    <span class="text-xs text-gray-400">
                                        {{ $plan->days()->count() }} Días planificados
                                    </span>
                                    <div class="btn-group">
                                        <a href="{{ route('trainer.plans.show', $plan) }}" class="btn btn-outline-primary btn-xs">
                                            Ver / Editar
                                        </a>
                                        <form action="{{ route('trainer.plans.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este plan? Se borrarán sus días y ejercicios.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card shadow-sm border-0 text-center py-5">
                            <div class="card-body">
                                <p class="text-gray-500 mb-4">No tienes planes de entrenamiento creados todavía.</p>
                                <a href="{{ route('trainer.plans.create') }}" class="btn btn-primary">
                                    Crear tu Primer Plan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
