<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">¡Bienvenido Administrador, {{ Auth::user()->name }}!</h3>
                    <p class="mb-6">Desde aquí tienes control total sobre los catálogos del sistema, usuarios y configuraciones generales.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h4 class="font-semibold mb-2">Gestión de Catálogos</h4>
                            <p class="text-sm text-gray-500 mb-4">Administra los ejercicios disponibles para los planes de entrenamiento.</p>
                            <a href="{{ route('admin.exercises.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-md shadow-sm">
                                Catálogo de Ejercicios
                            </a>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h4 class="font-semibold mb-2">Gestión de Usuarios</h4>
                            <p class="text-sm text-gray-500 mb-4">Administra atletas, entrenadores y sus correspondientes asignaciones.</p>
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-md shadow-sm">
                                Control de Usuarios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
