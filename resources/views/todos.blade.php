@extends('layouts.template')

@push('app-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-todo.css') }}">
@endpush

@section('app-content')
    @include('layouts.navbar')

    <div class="app-content content todo-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content todo-sidebar">
                        <div class="todo-app-menu">
                            <div class="add-task">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#new-task-modal">
                                    Crear nueva tarea
                                </button>
                            </div>
                            <div class="sidebar-menu-list">
                                <div class="list-group list-group-filters">
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                                        <i data-feather="mail" class="font-medium-3 mr-50"></i>
                                        <span class="align-middle">Mis Tareas</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <div class="todo-app-list">
                            <!-- Todo search starts -->
                            <div class="app-fixed-search d-flex align-items-center">
                                <div class="sidebar-toggle d-block d-lg-none ml-1">
                                    <i data-feather="menu" class="font-medium-5"></i>
                                </div>
                                <div class="d-flex align-content-center justify-content-between w-100">
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="search"
                                                    class="text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="todo-search"
                                            placeholder="Buscar todo" aria-label="Search..."
                                            aria-describedby="todo-search" />
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle hide-arrow mr-1" id="todoActions"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-vertical" class="font-medium-2 text-body"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="todoActions">
                                        <a class="dropdown-item sort-asc" href="javascript:void(0)">Sort A - Z</a>
                                        <a class="dropdown-item sort-desc" href="javascript:void(0)">Sort Z - A</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Todo search ends -->

                            <!-- Todo List starts -->
                            <div class="todo-task-list-wrapper list-group">
                                <ul class="todo-task-list media-list" id="todo-task-list">
                                </ul>
                                <div class="no-results">
                                    <h5>No se encontro ningun ToDo</h5>
                                </div>
                            </div>
                            <!-- Todo List ends -->
                        </div>

                        <!-- Right Sidebar starts -->
                        <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-task-modal">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">
                                    <form id="form-modal-todo" class="todo-modal needs-validation" novalidate
                                        onsubmit="return false">
                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title">Nueva tarea</h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ml-auto">
                                                <span class="todo-item-favorite cursor-pointer mr-75"><i data-feather="star"
                                                        class="font-medium-2"></i></span>
                                                <button type="button" class="close font-large-1 font-weight-normal py-0"
                                                    data-dismiss="modal" aria-label="Close">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                            <div class="action-tags">
                                                <div class="form-group">
                                                    <label for="todoTitleAdd" class="form-label">Titulo</label>
                                                    <input type="text" id="todoTitleAdd" name="title"
                                                        class="new-todo-item-title form-control" placeholder="Title"
                                                        required />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Description</label>
                                                    <div id="task-desc" class="border-bottom-0"
                                                        data-placeholder="Escribe la descripción"></div>
                                                    <div class="d-flex justify-content-end desc-toolbar border-top-0">
                                                        <span class="ql-formats mr-0">
                                                            <button class="ql-bold"></button>
                                                            <button class="ql-italic"></button>
                                                            <button class="ql-underline"></button>
                                                            <button class="ql-align"></button>
                                                            <button class="ql-link"></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group my-1">
                                                <button type="submit"
                                                    class="btn btn-primary d-none add-todo-item mr-1">Crear</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary add-todo-item d-none"
                                                    data-dismiss="modal">
                                                    Cerrar
                                                </button>
                                                <button type="button"
                                                    class="btn btn-primary d-none update-btn update-todo-item mr-1">Actualizar</button>
                                                <button type="button" class="btn btn-outline-danger update-btn d-none"
                                                    data-dismiss="modal" data-action="delete">Borrar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Right Sidebar ends -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('app-js')
    {{-- BEGIN: Page Vendor JS --}}
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dragula.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    {{-- END: Page Vendor JS --}}
    <script src="{{ asset('app-assets/js/scripts/pages/app-todo.js') }}"></script>
    <script>
        $todoList = $('#todo-task-list');
        $(document).ready(function() {
            fetchData();
        });

        function fetchData() {
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `api/todos`,
                    method: 'GET',
                    dataType: 'json',
                })
                .done((res) => {
                    $todoList.html('')
                    if (res.data.length == 0) {
                        $todoList.html(`
                        <div>
                            <h3 class="text-center my-5">No se encontro ningun ToDo, registra uno nuevo y hazle el seguimiento</h3>
                        </div>
                    `);
                    }

                    res.data.forEach(todo => {
                        const done = todo.done_at != null;
                        const li = `
                        <li class="todo-item ${done ? 'completed':''}" data-description="${todo.description}" data-id="${todo.id}" data-title="${todo.title}" data-done="${todo.done_at}">
                            <div class="todo-title-wrapper">
                                <div class="todo-title-area">
                                    <i data-feather="more-vertical" class="drag-icon"></i>
                                    <div class="title-wrapper">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="customCheck${todo.id}" ${done ? 'checked': ''} />
                                            <label class="custom-control-label" for="customCheck${todo.id}"></label>
                                        </div>
                                        <span class="todo-title">${todo.title}</span>
                                    </div>
                                </div>
                            </div>
                        </li>`;

                        $todoList.append(li);

                    });
                })
        }

        function doneTodo(id, action = null) {
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `api/todos/${id}/done`,
                    method: 'POST',
                    data: {
                        _method: 'PATCH'
                    },
                    dataType: 'json',
                })
                .done((res) => {
                    fetchData()
                    if (action == null) return;

                    if (action == 'done') {
                        toastr['success']('ToDo terminada exitosamente', '¡¡Felicitaciones!! 🎉', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                    } else {
                        toastr['info']('ToDo rehecho exitosamente', '¡A trabajar!', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                    }
                })
        }

        function updateTodo(id, data) {
            $.post(`api/todos/${id}`, {
                    ...data,
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'PUT'
                })
                .then(_ => {
                    toastr['success']('ToDo actualizado exitosamente', '¡¡Felicitaciones!! 🎉', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    fetchData()
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
                            toastr['error']('Hubo un error inesperado', 'Revise los logs del servidor', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                            break
                    }
                })
        }

        function deleteTodo(id) {
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `api/todos/${id}`,
                    method: 'POST',
                    data: {
                        _method: 'DELETE'
                    },
                    dataType: 'json',
                })
                .done((res) => {
                    fetchData();
                    toastr['success']('ToDo eliminado exitosamente', '👍🏻', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                })
        }
    </script>
@endpush
