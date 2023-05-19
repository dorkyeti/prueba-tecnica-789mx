@extends('layouts.template')

@section('app-content')
    {{-- Inicio de la carta --}}
    <div class="card my-2 border-0">
        {{-- Header de la carta --}}
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button class="btn btn-danger mx-1" id="delete-all-todos" @cannot('eliminar todos') disabled @endcannot>
                    Borrar ToDos Terminados
                </button>
                <button class="btn btn-primary" id="create-todos" data-toggle="modal" data-target="create-todos-modal"
                    @cannot('crear todos') disabled @endcannot>
                    Crear ToDo
                </button>
            </div>
        </div>
        {{-- Fin header de la carta --}}
        <div class="card-body py-3 px-2">
            <table id="allTodos" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Terminado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    {{-- Fin de la carta --}}

    {{-- Modal de ver --}}
    @component('components.modal', ['id' => 'view-todos-modal', 'title' => 'Ver ToDo'])
        @component('components.input', [
            'name' => 'title',
            'required' => true,
            'nombre' => 'Titulo',
            'readonly' => true,
        ])
        @endcomponent

        @component('components.textarea', [
            'name' => 'description',
            'nombre' => 'Descripcion',
            'required' => false,
            'readonly' => true,
        ])
        @endcomponent
        @slot('footer')
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary" data-action="done"></button>
            <button class="btn btn-primary" data-action="edit">Editar</button>
        @endslot
    @endcomponent
    {{-- Fin modal de ver --}}

    {{-- Modal de registro --}}
    @component('components.modal', ['id' => 'create-todos-modal', 'title' => 'Crear un nuevo ToDo'])
        @component('components.form', ['id' => 'create-todos-form'])
            @component('components.input', [
                'name' => 'title',
                'required' => true,
                'nombre' => 'Titulo',
            ])
            @endcomponent

            @component('components.textarea', [
                'name' => 'description',
                'nombre' => 'Descripcion',
                'required' => false,
            ])
            @endcomponent
        @endcomponent
        @slot('footer')
            <button class="btn btn-primary" form="create-todos-form">Enviar</button>
        @endslot
    @endcomponent
    {{-- Fin modal de registro --}}

    {{-- Modal de editar --}}
    @component('components.modal', ['id' => 'edit-todos-modal', 'title' => 'Editar un ToDo'])
        @component('components.form', ['id' => 'edit-todos-form', 'method' => 'PUT'])
            @component('components.input', [
                'name' => 'title',
                'required' => true,
                'nombre' => 'Titulo',
            ])
            @endcomponent

            @component('components.textarea', [
                'name' => 'description',
                'nombre' => 'Descripcion',
                'required' => false,
            ])
            @endcomponent
        @endcomponent
        @slot('footer')
            <button class="btn btn-primary" form="edit-todos-form">Editar</button>
        @endslot
    @endcomponent
    {{-- Fin modal de editar --}}
@endsection

@push('app-js')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
@endpush

@push('app-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />
@endpush
