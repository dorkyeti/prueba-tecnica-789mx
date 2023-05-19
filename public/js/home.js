$(document).ready(function () {
    // Definición de datatables
    const table = $('table#allTodos').DataTable({
        ajax: 'api/todos',
        columns: [
            { data: 'id' },
            { data: 'title' },
            {
                data: 'done_at',
                render: function (data, type) {
                    const result = (data == null) ? 'Sin terminar' : moment(data).locale('es').format('LLL');
                    return `<b>${result}</b>`
                }
            },
            {
                render: function (_, __, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-primary" data-action="done">${row['done_at'] == null ? '<i class="fa fa-check"></i>' : '<i class="fa fa-undo"></i>'}</button>
                            <button class="btn btn-primary" data-action="view"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-primary" data-action="edit"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger" data-action="delete"><i class="fa fa-trash"></i></button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
        },
        lengthMenu: [5, 10, 15, 20, 25, 50, 100],
        order: [[1, 'asc']],
    });
    // Formularios
    const forms = {
        'create': $('#create-todos-form'),
        'edit': $('#edit-todos-form')
    }
    // Modales
    const modals = {
        'create': $('#create-todos-modal'),
        'edit': $('#edit-todos-modal'),
        'view': $('#view-todos-modal')
    }
    // id del ToDo que se está viendo o editando
    let lastId = null;
    let lastRow = null;

    // Eventos en los botones
    table.on('click', 'button[data-action="edit"]', function (e) {
        e.preventDefault();

        const data = table.row($(this).parent().parent()).data();
        lastId = data.id;
        forms['edit'].find('input[name="title"]').val(data.title);
        forms['edit'].find('textarea[name="description"]').val(data.description);
        modals['edit'].modal('show');
    });

    table.on('click', 'button[data-action="delete"]', async function (e) {
        e.preventDefault();

        const { id } = table.row($(this).parent().parent()).data();

        const inputRes = await swal("¿Realmente desea eliminar este ToDo?", {
            buttons: ["No", "Sí"],
        });

        if (!inputRes)
            return;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `api/todos/${id}`,
            method: 'POST',
            data: { _method: 'DELETE' },
            dataType: 'json',
        })
            .done((res) => {
                table.ajax.reload(null, false);
                swal('ToDo eliminado con exito', 'Revisa la tabla', 'success');
            })
    });

    table.on('click', 'button[data-action="done"]', async function (e) {
        e.preventDefault();

        const { id, done_at } = table.row($(this).parent().parent()).data();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `api/todos/${id}/done`,
            method: 'POST',
            data: { _method: 'PATCH' },
            dataType: 'json',
        })
            .done((res) => {
                table.ajax.reload(null, false);
                swal(
                    done_at == null ? 'ToDo terminado' : 'ToDo deshecho',
                    'Revisa la tabla',
                    'success'
                );
            })
    });

    table.on('click', 'button[data-action="view"]', async function (e) {
        e.preventDefault();
        lastRow = $(this).parent().parent()

        const data = table.row(lastRow).data();
        lastId = data.id;
        modals['view'].find('input[name="title"]').val(data.title);
        modals['view'].find('textarea[name="description"]').val(data.description);
        modals['view'].find('button[data-action="done"]').html(
            data.done_at == null ? 'Terminar' : 'Rehacer'
        );

        modals['view'].modal('show');
    });

    $('button#create-todos').click(function (e) {
        e.preventDefault();

        modals['create'].modal('show')
    });

    $('button#delete-all-todos').click(async function (e) {
        e.preventDefault();

        const inputRes = await swal('Esta acción es inreversible', "Esta acción elimina todos los ToDos que estén marcados como terminados, ¿Seguro que desea continuar?", {
            buttons: ["No", "Sí"],
        });

        if (!inputRes)
            return;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `api/todos`,
            method: 'POST',
            data: { _method: 'DELETE' },
            dataType: 'json',
        })
            .done((res) => {
                table.ajax.reload(null, false);
                swal('ToDos eliminados con exito', 'Revisa la tabla', 'success');
            })
    });

    // Logica de los formularios
    forms['create'].submit(function (e) {
        e.preventDefault();
        const sumbitButton = $('button[form="create-todos-form"]');
        const oldInputValue = sumbitButton.html();
        sumbitButton.attr('disabled', true).html('Cargando...')

        $.post('api/todos', forms['create'].serialize())
            .then(_ => {
                modals['create'].modal('hide');
                forms['create'].trigger('reset');
                swal('ToDo registrado con exito', 'Revisa la tabla y recuerda terminarlo', 'success');
                table.ajax.reload(null, false);
            })
            .catch(err => {
                switch (err.status) {
                    case 403:
                    case 500:
                    case 422:
                        swal('Hubo un error', err.responseJSON.message, 'error');
                        break;
                    default:
                        swal('Hubo un error inesperado', 'Revise los logs del servidor', 'error')
                        break
                }
            })
            .always(() => {
                sumbitButton.removeAttr('disabled').html(oldInputValue)
            })
    });

    forms['edit'].submit(function (e) {
        e.preventDefault();
        const sumbitButton = $('button[form="edit-todos-form"]');
        const oldInputValue = sumbitButton.html();
        sumbitButton.attr('disabled', true).html('Cargando...')

        $.post(`api/todos/${lastId}`, forms['edit'].serialize())
            .then(_ => {
                modals['edit'].modal('hide');
                forms['edit'].trigger('reset');
                swal('ToDo editado con exito', 'Revisa la tabla y recuerda terminarlo', 'success');
                table.ajax.reload(null, false);
            })
            .catch(err => {
                switch (err.status) {
                    case 403:
                    case 500:
                    case 422:
                        swal('Hubo un error', err.responseJSON.message, 'error');
                        break;
                    default:
                        swal('Hubo un error inesperado', 'Revise los logs del servidor', 'error')
                        break
                }
            })
            .always(() => {
                sumbitButton.removeAttr('disabled').html(oldInputValue)
            })
    });

    // Logica de los modales
    modals['create'].on('hide.bs.modal', function () {
        forms['create'].trigger('reset')
    });

    modals['edit'].on('hide.bs.modal', function () {
        forms['edit'].trigger('reset');
        lastId = null;
    });

    modals['view'].on('hide.bs.modal', function () {
        lastId = null;
        lastRow = null;
        modals['view'].find('input[name="title"]').val(null);
        modals['view'].find('textarea[name="description"]').val(null);
    });

    modals['view'].on('click', 'button[data-action="done"]', async function (e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `api/todos/${lastId}/done`,
            method: 'POST',
            data: { _method: 'PATCH' },
            dataType: 'json',
        })
            .done((res) => {
                table.ajax.reload(null, false);
                modals['view'].modal('hide')
                swal(
                    'ToDo terminado',
                    'Revisa la tabla',
                    'success'
                );
            })
    })

    modals['view'].on('click', 'button[data-action="edit"]', async function (e) {
        e.preventDefault();
        const data = table.row(lastRow).data();
        modals['view'].modal('hide');
        lastId = data.id;
        forms['edit'].find('input[name="title"]').val(data.title);
        forms['edit'].find('textarea[name="description"]').val(data.description);
        modals['edit'].modal('show');
    })
});

