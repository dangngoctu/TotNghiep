$(function(){
    'use strict';
    var table_dynamic_category = $('.table-dynamic-category').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_category",
        "responsive": true,
        "scrollX": true,
        "pagingType": "full_numbers",
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
            {"data": "name"},
            {"data": "description", "searchable": false},
            {"data": "action", "searchable": false}
		],
		"columnDefs": [
            {
				targets: [0],
				class: 'text-center'
            },
            {
                orderable: false,
                targets: [1],
                class: 'multi-line'
            },
            {
                orderable: false,
                targets: [2],
                class: 'multi-line'
            },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center'
			}
		]
	});
    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#group-category-id').select2({
        minimumResultsForSearch: Infinity
    });
    $(document).on('click', '.table-dynamic-category .table-action-delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#confirm-delete-modal #id').val(id);
        $('#confirm-delete-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
    });
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
        DeleteCategory(id, table_dynamic_category);
    });
    $(document).on('click', '.table-dynamic-category .table-action-edit', function (e) {
        $('#modal-category #ttlModal').html('Update category');
        $('#modal-category').modal('show');
    });
    $(document).on('click', '#addCategory', function (e) {
		e.preventDefault();
        $('#CategoryForm')[0].reset();
        var lang = $(this).attr('data-lang');
        ClearFormCategory(lang, 'add');
		$('#modal-category').modal('show');
    });
    $(document).on('click', '#btnCategory', function (e) {
        e.preventDefault();
        $('#CategoryForm').submit();
    });
    $("#CategoryForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            CategoryFormSubmit(table_dynamic_category);
        }
    });

    $(document).on('click', '.table-dynamic-category .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormCategory(lang, 'edit');
        UpdateCategory(id, lang);
    });

    $('#CategoryForm').on('change input', function() {
        $('#modal-category').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});

var ClearFormCategory = function(lang, type) {
    $('#CategoryForm').parsley().reset();
    $('#modal-category #lang').val(lang);
    if (type == "add") {
        $('#modal-category #ttlModal').html('Add category');
        $('#modal-category #action').val('insert');
        $('#CategoryForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else {
        $('#modal-category #ttlModal').html('Update category');
        $('#modal-category #action').val('update');
    }
    $('#modal-category').find('button.btn-primary').prop('disabled', true);
};

var UpdateCategory = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_category?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                
                if (typeof response.data.m_categories_translations !== "undefined") {
                    $('#modal-category #id').val(response.data.id);
                    $('#modal-category #description').val(response.data.m_categories_translations.description);
                    $('#modal-category #name').val(response.data.m_categories_translations.name);
                }
                $('#modal-category').modal('show');
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
            $('#CategoryForm').each(function() {
                $(this).data('serialized', $(this).serialize())
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: response.msg
            });
        }
    });
};

var CategoryFormSubmit = function(table) {
    $('#btnCategory').attr('disabled', true);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_category",
        type: "post",
        data: $('#CategoryForm').serialize(),
        success: function(response) {
            if (response.code == '200') {
                Lobibox.notify("success", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
                table.ajax.reload(null, true);
                // $('#btnGroupCategory').button('reset');
                $('#modal-category').modal('hide');
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: 'There was an error during processing'
            });
        }
    });
};

var DeleteCategory = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_category?action=delete&id=" + id,
        type: "post",
        success: function(response) {
            if (response.code == '200') {
                Lobibox.notify("success", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
                table.ajax.reload(null, true);
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
            // $('#confirm-delete-modal #confirm-delete').button('reset');
            $('#confirm-delete-modal').modal('hide');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: 'There was an error during processing'
            });
            // $('#confirm-delete-modal #confirm-delete').button('reset');
            $('#confirm-delete-modal').modal('hide');
        }
    });
};