<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ __('Control de Usuarios y Asignaciones') }}
            </h2>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                + Crear Usuario
            </button>
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Entrenador Asignado</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                    <tr>
                                        <td class="ps-4 font-semibold text-gray-900">{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            @php
                                                $roleBadge = match($u->role->name) {
                                                    'admin' => 'bg-danger text-white',
                                                    'trainer' => 'bg-warning text-dark',
                                                    'athlete' => 'bg-success text-white',
                                                    default => 'bg-secondary text-white'
                                                };
                                            @endphp
                                            <span class="badge {{ $roleBadge }}">
                                                {{ $u->role->display_name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($u->isAthlete())
                                                @php
                                                    $assignedTrainer = $u->trainers->first();
                                                @endphp
                                                <form action="{{ route('admin.users.assign-trainer', $u) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <div class="input-group input-group-sm" style="max-width: 250px;">
                                                        <select class="form-select form-select-sm" name="trainer_id" onchange="this.form.submit()">
                                                            <option value="">-- Sin Entrenador --</option>
                                                            @foreach($trainers as $t)
                                                                <option value="{{ $t->id }}" {{ $assignedTrainer && $assignedTrainer->id === $t->id ? 'selected' : '' }}>
                                                                    {{ $t->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>
                                            @else
                                                <span class="text-muted text-xs">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-warning btn-xs" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $u->id }}">
                                                    Editar
                                                </button>
                                                
                                                @if($u->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-xs">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Editar Usuario -->
                                    <div class="modal fade" id="editUserModal-{{ $u->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $u->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.users.update', $u) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-semibold" id="editUserModalLabel-{{ $u->id }}">Editar Usuario: {{ $u->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label font-medium">Nombre</label>
                                                            <input type="text" class="form-control" name="name" value="{{ old('name', $u->name) }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label font-medium">Email</label>
                                                            <input type="email" class="form-control" name="email" value="{{ old('email', $u->email) }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label font-medium">Rol</label>
                                                            <select class="form-select" name="role_id" required>
                                                                @foreach($roles as $r)
                                                                    <option value="{{ $r->id }}" {{ $u->role_id === $r->id ? 'selected' : '' }}>
                                                                        {{ $r->display_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="border-top pt-3 mt-3">
                                                            <h6 class="font-semibold text-sm mb-2 text-muted">Cambiar Contraseña (Opcional)</h6>
                                                            <div class="mb-2">
                                                                <label class="form-label text-xs">Nueva Contraseña</label>
                                                                <input type="password" class="form-control form-control-sm" name="password" placeholder="Mínimo 8 caracteres">
                                                            </div>
                                                            <div>
                                                                <label class="form-label text-xs">Confirmar Contraseña</label>
                                                                <input type="password" class="form-control form-control-sm" name="password_confirmation">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="createUserModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-semibold" id="createUserModalLabel">Crear Nuevo Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label font-medium">Nombre</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Ej. Juan Pérez">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-medium">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Ej. juan@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-medium">Rol</label>
                            <select class="form-select" name="role_id" required>
                                <option value="" disabled selected>Selecciona rol...</option>
                                @foreach($roles as $r)
                                    <option value="{{ $r->id }}" {{ old('role_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-medium">Contraseña</label>
                                <input type="password" class="form-control" name="password" required placeholder="Min 8 carac.">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-medium">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
