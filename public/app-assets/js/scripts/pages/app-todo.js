/*=========================================================================================
    File Name: app-todo.js
    Description: app-todo
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

'use strict';

$(function () {
  var taskTitle,
    flatPickr = $('.task-due-date'),
    newTaskModal = $('.sidebar-todo-modal'),
    newTaskForm = $('#form-modal-todo'),
    favoriteStar = $('.todo-item-favorite'),
    modalTitle = $('.modal-title'),
    addBtn = $('.add-todo-item'),
    addTaskBtn = $('.add-task button'),
    updateTodoItem = $('.update-todo-item'),
    updateBtns = $('.update-btn'),
    taskDesc = $('#task-desc'),
    taskAssignSelect = $('#task-assigned'),
    taskTag = $('#task-tag'),
    overlay = $('.body-content-overlay'),
    menuToggle = $('.menu-toggle'),
    sidebarToggle = $('.sidebar-toggle'),
    sidebarLeft = $('.sidebar-left'),
    sidebarMenuList = $('.sidebar-menu-list'),
    todoFilter = $('#todo-search'),
    sortAsc = $('.sort-asc'),
    sortDesc = $('.sort-desc'),
    todoTaskList = $('.todo-task-list'),
    todoTaskListWrapper = $('.todo-task-list-wrapper'),
    listItemFilter = $('.list-group-filters'),
    noResults = $('.no-results'),
    checkboxId = 100;

  var assetPath = '../../../app-assets/';
  if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
  }

  // if it is not touch device
  if (!$.app.menu.is_touch_device()) {
    if (sidebarMenuList.length > 0) {
      var sidebarListScrollbar = new PerfectScrollbar(sidebarMenuList[0], {
        theme: 'dark'
      });
    }
    if (todoTaskListWrapper.length > 0) {
      var taskListScrollbar = new PerfectScrollbar(todoTaskListWrapper[0], {
        theme: 'dark'
      });
    }
  }
  // if it is a touch device
  else {
    sidebarMenuList.css('overflow', 'scroll');
    todoTaskListWrapper.css('overflow', 'scroll');
  }

  // Add class active on click of sidebar filters list
  if (listItemFilter.length) {
    listItemFilter.find('a').on('click', function () {
      if (listItemFilter.find('a').hasClass('active')) {
        listItemFilter.find('a').removeClass('active');
      }
      $(this).addClass('active');
    });
  }

  // Init D'n'D
  var dndContainer = document.getElementById('todo-task-list');
  if (typeof dndContainer !== undefined && dndContainer !== null) {
    dragula([dndContainer], {
      moves: function (el, container, handle) {
        return handle.classList.contains('drag-icon');
      }
    });
  }

  // Main menu toggle should hide app menu
  if (menuToggle.length) {
    menuToggle.on('click', function (e) {
      sidebarLeft.removeClass('show');
      overlay.removeClass('show');
    });
  }

  // Todo sidebar toggle
  if (sidebarToggle.length) {
    sidebarToggle.on('click', function (e) {
      e.stopPropagation();
      sidebarLeft.toggleClass('show');
      overlay.addClass('show');
    });
  }

  // On Overlay Click
  if (overlay.length) {
    overlay.on('click', function (e) {
      sidebarLeft.removeClass('show');
      overlay.removeClass('show');
      $(newTaskModal).modal('hide');
    });
  }

  // Assign task
  function assignTask(option) {
    if (!option.id) {
      return option.text;
    }
    var $person =
      '<div class="media align-items-center">' +
      '<img class="d-block rounded-circle mr-50" src="' +
      $(option.element).data('img') +
      '" height="26" width="26" alt="' +
      option.text +
      '">' +
      '<div class="media-body"><p class="mb-0">' +
      option.text +
      '</p></div></div>';

    return $person;
  }

  // Task Assign Select2
  if (taskAssignSelect.length) {
    taskAssignSelect.wrap('<div class="position-relative"></div>');
    taskAssignSelect.select2({
      placeholder: 'Unassigned',
      dropdownParent: taskAssignSelect.parent(),
      templateResult: assignTask,
      templateSelection: assignTask,
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  // Task Tags
  if (taskTag.length) {
    taskTag.wrap('<div class="position-relative"></div>');
    taskTag.select2({
      placeholder: 'Select tag'
    });
  }

  // Favorite star click
  if (favoriteStar.length) {
    $(favoriteStar).on('click', function () {
      $(this).toggleClass('text-warning');
    });
  }

  // Flat Picker
  if (flatPickr.length) {
    flatPickr.flatpickr({
      dateFormat: 'Y-m-d',
      defaultDate: 'today',
      onReady: function (selectedDates, dateStr, instance) {
        if (instance.isMobile) {
          $(instance.mobileInput).attr('step', null);
        }
      }
    });
  }

  // Todo Description Editor
  if (taskDesc.length) {
    var todoDescEditor = new Quill('#task-desc', {
      bounds: '#task-desc',
      modules: {
        formula: true,
        syntax: true,
        toolbar: '.desc-toolbar'
      },
      placeholder: 'Escribe aqui tu descripción',
      theme: 'snow'
    });
  }

  // On add new item button click, clear sidebar-right field fields
  if (addTaskBtn.length) {
    addTaskBtn.on('click', function (e) {
      addBtn.removeClass('d-none');
      updateBtns.addClass('d-none');
      modalTitle.text('Nueva tarea');
      // newTaskModal.modal('show');
      sidebarLeft.removeClass('show');
      overlay.removeClass('show');
      newTaskModal.find('.new-todo-item-title').val('');
      var quill_editor = taskDesc.find('.ql-editor');
      quill_editor[0].innerHTML = '';
    });
  }

  // Add New ToDo List Item

  // To add new todo form
  if (newTaskForm.length) {
    newTaskForm.validate({
      ignore: '.ql-container *', // ? ignoring quill editor icon click, that was creating console error
      rules: {
        todoTitleAdd: {
          required: true
        },
        'task-assigned': {
          required: true
        },
        'task-due-date': {
          required: true
        }
      }
    });

    newTaskForm.on('submit', function (e) {
      e.preventDefault();
      const isValid = newTaskForm.valid();

      if (!isValid) return;

      const todoTitle = $('.sidebar-todo-modal .new-todo-item-title').val();
      const todoDescription = $('.sidebar-todo-modal #task-desc').text()
      $.post('api/todos', {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'title': todoTitle,
        'description': todoDescription
      })
        .then(_ => {
          // modals['create'].modal('hide');
          // forms['create'].trigger('reset');
          // swal('ToDo registrado con exito', 'Revisa la tabla y recuerda terminarlo', 'success');
          // table.ajax.reload(null, false);
          $(newTaskModal).modal('hide');
          overlay.removeClass('show');
          toastr['success']('Todo creado con exito', '¡A trabajar!', {
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
              // swal('Hubo un error', err.responseJSON.message, 'error');
              toastr['error']('Hubo un error', err.responseJSON.message, {
                closeButton: true,
                tapToDismiss: false
              });
              break;
            default:
              // swal('Hubo un error inesperado', 'Revise los logs del servidor', 'error')
              toastr['error']('Hubo un error inesperado', 'Revise los logs del servidor', {
                closeButton: true,
                tapToDismiss: false
              });
              break
          }
        })
    });
  }

  // Task checkbox change
  todoTaskListWrapper.on('change', '.custom-checkbox', function (event) {
    var $this = $(this).find('input');
    const { id } = $this.closest('.todo-item').data();
    doneTodo(id);
    if ($this.prop('checked')) {
      $this.closest('.todo-item').addClass('completed');
      toastr['success']('ToDo terminada exitosamente', '¡¡Felicitaciones!! 🎉', {
        closeButton: true,
        tapToDismiss: false
      });
    } else {
      $this.closest('.todo-item').removeClass('completed');
      toastr['info']('ToDo rehecho exitosamente', '¡A trabajar!', {
        closeButton: true,
        tapToDismiss: false
      });
    }
  });
  todoTaskListWrapper.on('click', '.custom-checkbox', function (event) {
    event.stopPropagation();
  });

  // To open todo list item modal on click of item
  $(document).on('click', '.todo-task-list-wrapper .todo-item', function (e) {
    const data = $(this).data();
    newTaskModal.modal('show');
    addBtn.addClass('d-none');
    updateBtns.removeClass('d-none');
    if ($(this).hasClass('completed')) {
      modalTitle.html(
        `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light" data-dismiss="modal" data-action="done" data-id="${data.id}" onclick="doneTodo('${data.id}', 'done')">Rehacer</button>`
      );
    } else {
      modalTitle.html(
        `<button type="button" class="btn btn-sm btn-outline-secondary complete-todo-item waves-effect waves-float waves-light" data-dismiss="modal" data-action="done" data-id="${data.id}" onclick="doneTodo('${data.id}', 'undone')">Terminar</button>`
      );
    }
    taskTag.val('').trigger('change');
    var quill_editor = $('#task-desc .ql-editor'); // ? Dummy data as not connected with API or anything else
    quill_editor[0].innerHTML = data.description;
    taskTitle = $(this).find('.todo-title');
    var $title = $(this).find('.todo-title').html();

    // apply all variable values to fields
    newTaskForm.find('.new-todo-item-title').val($title);
  });

  // Updating Data Values to Fields
  if (updateTodoItem.length) {
    updateTodoItem.on('click', function (e) {
      e.preventDefault();
      const { id } = newTaskForm.find('button[data-action="done"]').data();

      updateTodo(id, {
        title: newTaskForm.find('.new-todo-item-title').val(),
        description: newTaskForm.find('#task-desc').text()
      });

      $('#new-task-modal').modal('hide');
    });
  }

  // Delet a todo
  $('button[data-action="delete"]').on('click', function (e) {
    e.preventDefault();

    const { id } = newTaskForm.find('button[data-action="done"]').data();
    deleteTodo(id);
  })

  // Sort Ascending
  if (sortAsc.length) {
    sortAsc.on('click', function () {
      todoTaskListWrapper
        .find('li')
        .sort(function (a, b) {
          return $(b).find('.todo-title').text().toUpperCase() < $(a).find('.todo-title').text().toUpperCase() ? 1 : -1;
        })
        .appendTo(todoTaskList);
    });
  }
  // Sort Descending
  if (sortDesc.length) {
    sortDesc.on('click', function () {
      todoTaskListWrapper
        .find('li')
        .sort(function (a, b) {
          return $(b).find('.todo-title').text().toUpperCase() > $(a).find('.todo-title').text().toUpperCase() ? 1 : -1;
        })
        .appendTo(todoTaskList);
    });
  }

  // Filter task
  if (todoFilter.length) {
    todoFilter.on('keyup', function () {
      var value = $(this).val().toLowerCase();
      if (value !== '') {
        $('.todo-item').filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
        var tbl_row = $('.todo-item:visible').length; //here tbl_test is table name

        //Check if table has row or not
        if (tbl_row == 0) {
          if (!$(noResults).hasClass('show')) {
            $(noResults).addClass('show');
          }
        } else {
          $(noResults).removeClass('show');
        }
      } else {
        // If filter box is empty
        $('.todo-item').show();
        if ($(noResults).hasClass('show')) {
          $(noResults).removeClass('show');
        }
      }
    });
  }

  // For chat sidebar on small screen
  if ($(window).width() > 992) {
    if (overlay.hasClass('show')) {
      overlay.removeClass('show');
    }
  }
});

$(window).on('resize', function () {
  // remove show classes from sidebar and overlay if size is > 992
  if ($(window).width() > 992) {
    if ($('.body-content-overlay').hasClass('show')) {
      $('.sidebar-left').removeClass('show');
      $('.body-content-overlay').removeClass('show');
      $('.sidebar-todo-modal').modal('hide');
    }
  }
});
