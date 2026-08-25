<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control - Entrenador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">¡Bienvenido Entrenador, {{ Auth::user()->name }}!</h3>
                    <p class="mb-4">Desde aquí puedes gestionar tus atletas asignados y planificar sus rutinas de entrenamiento.</p>
                    
                    <h4 class="font-medium text-base border-b pb-2 mb-3">Tus Atletas Asignados</h4>
                    @if(Auth::user()->athletes->isEmpty())
                        <p class="text-sm text-gray-500 italic">Actualmente no tienes ningún atleta asignado.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach(Auth::user()->athletes as $athlete)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-semibold">{{ $athlete->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $athlete->email }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
