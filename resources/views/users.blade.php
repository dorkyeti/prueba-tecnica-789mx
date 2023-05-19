@extends('layouts.template')

@section('app-content')
    {{-- Inicio de la carta --}}
    <div class="card my-2 border-0">
        {{-- Header de la carta --}}
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" id="register-user" data-toggle="modal" data-target="register-users-modal"
                    @cannot('crear usuarios') disabled @endcannot>
                    Registrar usuario
                </button>
            </div>
        </div>
        {{-- Fin del header de la carta --}}

        {{-- Cuerpo de la carta --}}
        <div class="card-body py-3 px-2">
            <table id="allUsers" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- Fin del cuerpo de la carta --}}
    </div>
    {{-- Fin de la carta --}}

    {{-- Modales --}}
    {{-- Modal de ver --}}
    @component('components.modal', ['id' => 'view-users-modal', 'title' => 'Ver Usuario'])
        @component('components.input', [
            'name' => 'name',
            'required' => true,
            'nombre' => 'Nombre',
            'readonly' => true,
        ])
        @endcomponent

        @component('components.input', [
            'name' => 'email',
            'required' => true,
            'nombre' => 'Email',
            'readonly' => true,
            'type' => 'email',
        ])
        @endcomponent

        @component('components.input', [
            'name' => 'role',
            'required' => true,
            'nombre' => 'Rol',
            'readonly' => true,
            'type' => 'string',
        ])
        @endcomponent

        @slot('footer')
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary" data-action="edit">Editar</button>
        @endslot
    @endcomponent
    {{-- Fin modal de ver --}}

    {{-- Modal de registro --}}
    @component('components.modal', ['id' => 'register-users-modal', 'title' => 'Registrar un nuevo Usuario'])
        @component('components.form', ['id' => 'register-users-form'])
            @component('components.input', [
                'name' => 'name',
                'required' => true,
                'nombre' => 'Nombre',
            ])
            @endcomponent

            @component('components.input', [
                'name' => 'email',
                'required' => true,
                'nombre' => 'Email',
                'type' => 'email',
            ])
            @endcomponent

            @component('components.input', [
                'name' => 'password',
                'required' => true,
                'nombre' => 'Contraseña',
                'type' => 'password',
            ])
            @endcomponent

            <div class="col form-group">
                <label for="role">Rol</label>
                <select class="form-control" name="role" id="role" required>
                    <option disabled selected>Seleccione</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        @endcomponent
        @slot('footer')
            <button class="btn btn-primary" form="register-users-form">Enviar</button>
        @endslot
    @endcomponent
    {{-- Fin modal de registro --}}

    {{-- Modal de editar --}}
    @component('components.modal', ['id' => 'edit-users-modal', 'title' => 'Editar a un  Usuario'])
        @component('components.form', ['id' => 'edit-users-form', 'method' => 'PUT'])
            @component('components.input', [
                'name' => 'name',
                'required' => true,
                'nombre' => 'Nombre',
            ])
            @endcomponent

            @component('components.input', [
                'name' => 'email',
                'required' => true,
                'nombre' => 'Email',
                'type' => 'email',
            ])
            @endcomponent

            @component('components.input', [
                'name' => 'password',
                'required' => false,
                'nombre' => 'Contraseña',
                'type' => 'password',
            ])
            @endcomponent

            <div class="col form-group">
                <label for="role">Rol</label>
                <select class="form-control" name="role" id="role" required>
                    <option disabled selected>Seleccione</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        @endcomponent
        @slot('footer')
            <button class="btn btn-primary" form="edit-users-form">Editar</button>
        @endslot
    @endcomponent
    {{-- Fin modal de editar --}}
@endsection

@push('app-js')
    <script src="{{ asset('js/users.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
@endpush

@push('app-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />
@endpush
