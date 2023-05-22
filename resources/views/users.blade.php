@extends('layouts.template') @section('app-content')
    @include('layouts.navbar')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                {{-- Header --}}
                                <div class="card-header border-bottom px-1">
                                    <div class="head-lead">
                                        <h6 class="mb-0">Listado de usuarios</h6>
                                    </div>

                                    <div class="dt-action-buttons text-right">
                                        <div class="dt-buttons d-inline-flex">
                                            <button class="dt-button create-new btn btn-primary" id="register-user"
                                                data-toggle="modal" data-target="#register-users-modal"
                                                @cannot('crear usuarios') disabled @endcannot>
                                                Registrar usuario
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fin header --}}
                                <div class="card-body">
                                    <div class="">
                                        <table class="table table-bordered table-striped" id="allUsers">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                    <th>Rol</th>
                                                    {{-- <th>Opciones</th> --}}
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- Modal para añadir un nuevo usuario --}}
        <div class="modal modal-slide-in fade" id="register-users-modal">
            <div class="modal-dialog sidebar-sm">
                <form class="add-new-record modal-content pt-0" id="register-users-form">
                    @csrf
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="modal-title">Nuevo usuario</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="form-group">
                            <label class="form-label" for="name">Nombre</label>
                            <input type="text" class="form-control dt-full-name" id="name" placeholder="John Doe"
                                name="name" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" class="form-control dt-email"
                                placeholder="john.doe@example.com" name="email" required />
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" id="password" class="form-control dt-password" placeholder="********"
                                name="password" required />
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="role">Rol</label>
                            <select class="form-control" name="role" id="role" required>
                                <option disabled selected>Seleccione</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary data-submit mr-1" id="form-button-save"
                            form="register-users-form">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Fin Modal para añadir un nuevo usuario --}}

        {{-- Modal para editar a un usuario --}}
        <div class="modal modal-slide-in fade" id="edit-users-modal">
            <div class="modal-dialog sidebar-sm">
                <form class="add-new-record modal-content pt-0" id="edit-users-form">
                    @csrf
                    @method('PUT')
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="modal-title">Editar usuario usuario</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="form-group">
                            <label class="form-label" for="name">Nombre</label>
                            <input type="text" class="form-control dt-full-name" id="name" placeholder="John Doe"
                                name="name" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" class="form-control dt-email"
                                placeholder="john.doe@example.com" name="email" required />
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" id="password" class="form-control dt-password"
                                placeholder="********" name="password" />
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="role">Rol</label>
                            <select class="form-control" name="role" id="role" required>
                                <option disabled selected>Seleccione</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary data-submit mr-1" id="form-button-edit"
                            form="edit-users-form">Actualizar</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                            id="delete-user">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Fin Modal para editar a un usuario --}}
    </div>
@endsection

@push('app-js')
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const table = $('table#allUsers').DataTable({
                ajax: 'api/users',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'role'
                    },
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
                },
                lengthMenu: [5, 10, 15, 20, 25, 50, 100],
                order: [
                    [1, 'asc']
                ],
            });

            $('#register-users-form').on('submit', function(e) {
                e.preventDefault();

                $.post('api/users', $(this).closest('form').serialize())
                    .then(_ => {
                        $('#register-users-modal').modal('hide');
                        $(this).closest('form').trigger('reset');
                        toastr['success']('Usuario creado con exito', 'Felicidades', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                        table.ajax.reload(null, false);
                    })
                    .catch(err => {
                        switch (err.status) {
                            case 403:
                            case 500:
                            case 422:
                                toastr['error']('Hubo un error', err.responseJSON.message, {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                break;
                            default:
                                toastr['error']('Hubo un error inesperado',
                                    'Revise los logs del servidor', {
                                        closeButton: true,
                                        tapToDismiss: false
                                    });
                                break
                        }
                    })
            });


            table.on('click', 'tr', function(e) {
                e.preventDefault();

                const data = table.row($(this)).data();
                const form = $('#edit-users-form');

                form.data('id', data.id);
                form.find('input[name="name"]').val(data.name);
                form.find('input[name="email"]').val(data.email);
                form.find('select[name="role"]').val(data.role_id).change();
                $('#edit-users-modal').modal('show');
            })

            $('#delete-user').on('click', function(e) {
                e.preventDefault();

                const form = $('#edit-users-form');
                const id = form.data('id');

                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `api/users/${id}`,
                        method: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        dataType: 'json',
                    })
                    .done((res) => {
                        table.ajax.reload(null, false);
                        toastr['success']('Usuario eliminado con exito', 'Felicidades', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                        $('#edit-users-modal').modal('hide');
                    })
                    .fail(err => {
                        switch (err.status) {
                            case 403:
                            case 500:
                            case 422:
                                toastr['error']('Hubo un error', err.responseJSON.message, {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                break;
                            default:
                                toastr['error']('Hubo un error inesperado',
                                    'Revise los logs del servidor', {
                                        closeButton: true,
                                        tapToDismiss: false
                                    });
                                break
                        }
                    })
            });

            $('#edit-users-form').on('submit', function(e) {
                e.preventDefault()

                const form = $('#edit-users-form');
                const id = form.data('id');

                $.post(`api/users/${id}`, form.serialize())
                    .then(_ => {
                        $('#edit-users-modal').modal('hide');
                        form.trigger('reset');
                        table.ajax.reload(null, false);
                        toastr['success']('Usuario actualizado con exito', 'Felicidades', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                        $('#edit-users-modal').modal('hide');
                    })
                    .catch(err => {
                        switch (err.status) {
                            case 403:
                            case 500:
                            case 422:
                                toastr['error']('Hubo un error', err.responseJSON.message, {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                break;
                            default:
                                toastr['error']('Hubo un error inesperado',
                                    'Revise los logs del servidor', {
                                        closeButton: true,
                                        tapToDismiss: false
                                    });
                                break
                        }
                    })
            })
        });
    </script>
@endpush
