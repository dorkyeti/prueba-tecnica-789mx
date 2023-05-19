$(document).ready(function () {
    // Datatables
    const table = $('table#allUsers').DataTable({
        ajax: 'api/users',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role' },
            {
                render: function (_, __, row) {
                    return `
                        <div class="btn-group">
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
        'create': $('#register-users-form'),
        'edit': $('#edit-users-form')
    }
    // Modales
    const modals = {
        'create': $('#register-users-modal'),
        'edit': $('#edit-users-modal'),
        'view': $('#view-users-modal')
    }

    // id del ultimo usuario que se está viendo o editando
    let lastId = null;
    let lastRow = null;

    // Botones de la tabla
    table.on('click', 'button[data-action="edit"]', function (e) {
        e.preventDefault();

        const data = table.row($(this).parent().parent()).data();
        lastId = data.id;
        forms['edit'].find('input[name="name"]').val(data.name);
        forms['edit'].find('input[name="email"]').val(data.email);
        forms['edit'].find('select[name="role"]').val(data.role_id).change();
        modals['edit'].modal('show');
    });

    table.on('click', 'button[data-action="delete"]', async function (e) {
        e.preventDefault();

        const { id } = table.row($(this).parent().parent()).data();

        const inputRes = await swal("¿Realmente desea eliminar este Usuario?", {
            buttons: ["No", "Sí"],
        });

        if (!inputRes)
            return;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `api/users/${id}`,
            method: 'POST',
            data: { _method: 'DELETE' },
            dataType: 'json',
        })
            .done((res) => {
                table.ajax.reload(null, false);
                swal('Usuario eliminado con exito', 'Revisa la tabla', 'success');
            })
            .fail(err => {
                switch (err.status) {
                    case 403:
                    case 500:
                        swal('Hubo un error', err.responseJSON.message, 'error');
                        break;
                    default:
                        swal('Hubo un error inesperado', 'Revise los logs del servidor', 'error')
                        break
                }
            })
    });

    table.on('click', 'button[data-action="view"]', async function (e) {
        e.preventDefault();
        lastRow = $(this).parent().parent()

        const data = table.row(lastRow).data();
        lastId = data.id;
        modals['view'].find('input[name="name"]').val(data.name);
        modals['view'].find('input[name="email"]').val(data.email);
        modals['view'].find('input[name="role"]').val(data.role);

        modals['view'].modal('show');
    });

    $('button#register-user').click(function (e) {
        e.preventDefault();

        modals['create'].modal('show')
    });

    // Formularios
    forms['create'].submit(function (e) {
        e.preventDefault();
        const sumbitButton = $('button[form="register-users-form"]');
        const oldInputValue = sumbitButton.html();
        sumbitButton.attr('disabled', true).html('Cargando...')

        $.post('api/users', forms['create'].serialize())
            .then(_ => {
                modals['create'].modal('hide');
                forms['create'].trigger('reset');
                swal('Usuario registrado con exito', 'Revisa la tabla', 'success');
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
        const sumbitButton = $('button[form="edit-users-form"]');
        const oldInputValue = sumbitButton.html();
        sumbitButton.attr('disabled', true).html('Cargando...')

        $.post(`api/users/${lastId}`, forms['edit'].serialize())
            .then(_ => {
                modals['edit'].modal('hide');
                forms['edit'].trigger('reset');
                swal('Usuario editado con exito', 'Revisa la tabla', 'success');
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

    // Modales de nuevo
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
        modals['view'].find('input[name="name"]').val(null);
        modals['view'].find('input[name="email"]').val(null);
        modals['view'].find('input[name="role"]').val(null);
    });

    modals['view'].on('click', 'button[data-action="edit"]', async function (e) {
        e.preventDefault();
        const data = table.row(lastRow).data();
        modals['view'].modal('hide');
        lastId = data.id;
        forms['edit'].find('input[name="name"]').val(data.name);
        forms['edit'].find('input[name="email"]').val(data.email);
        forms['edit'].find('select[name="role"]').val(data.role_id).change();
        modals['edit'].modal('show');
    })
});