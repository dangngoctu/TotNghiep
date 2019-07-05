$(function(){
    'use strict';
    var table_dynamic_fail_mode = $('.table-dynamic-fail-mode').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_fail_mode",
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
            // {"data": "category"},
            {"data": "category_name", "searchable": false},
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
    $('#category-code, #group-category-id').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $('#group-category-id').on("change", function (e) {
        $('#category-code').parents('.row').removeClass('d-none');
    });
    $(document).on('click', '.table-dynamic-fail-mode .table-action-delete', function (e) {
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
        DeleteFailureMode(id, table_dynamic_fail_mode);
    });

    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
    });
    $(document).on('click', '.table-dynamic-fail-mode .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormFailureMode(lang, 'edit');
        UpdateFailureMode(id, lang);
    });
    $(document).on('click', '#addFailMode', function (e) {
		e.preventDefault();
        $('#FailModeForm')[0].reset();
        var lang = $(this).attr('data-lang');
        ClearFormFailureMode(lang, 'add');
		$('#modal-fail-mode').modal('show');
    });
    $(document).on('click', '#btnFailMode', function (e) {
        e.preventDefault();
        $('#FailModeForm').submit();
    });
    $("#FailModeForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            FailureModeFormSubmit(table_dynamic_fail_mode);
        }
    });
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_category"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var description = '';
            if(item.description != null && item.description != ''){
                description = ' ('+item.description+')';
            }
            var option = new Option(item.name+description , item.id, false, false);'('+item.description+')'
            $('#category_id').append(option);
        })
    }).then(function () {
        $('#category_id').val('').trigger('change.select2');
    });
    $('#FailModeForm').on('change input', function() {
        $('#modal-fail-mode').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});

var ClearFormFailureMode = function(lang, type) {
    $('#FailModeForm').parsley().reset();
    $('#modal-fail-mode #lang').val(lang);
    $('#modal-fail-mode #category_id').val('').trigger('change.select2');
    if (type == "add") {
        $('#modal-fail-mode #ttlModal').html('Add failure mode');
        $('#modal-fail-mode #action').val('insert');
        $('#FailModeForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else {
        $('#modal-fail-mode #ttlModal').html('Update failure mode');
        $('#modal-fail-mode #action').val('update');
    }
    $('#modal-fail-mode').find('button.btn-primary').prop('disabled', true);
};

var UpdateFailureMode = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_fail_mode?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                if (typeof response.data.m_falure_mode_translations !== "undefined") {
                    $('#modal-fail-mode #id').val(response.data.id);
                    $('#modal-fail-mode #name').val(response.data.m_falure_mode_translations.name);
                    $('#modal-fail-mode #category_id').val(response.data.m_category.id).trigger('change.select2');
                }
                $('#modal-fail-mode').modal('show');
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
            $('#FailModeForm').each(function() {
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

var FailureModeFormSubmit = function(table) {
    $('#btnFailMode').attr('disabled', true);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_fail_mode",
        type: "post",
        data: $('#FailModeForm').serialize(),
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
                $('#modal-fail-mode').modal('hide');
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

var DeleteFailureMode = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_fail_mode?action=delete&id=" + id,
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