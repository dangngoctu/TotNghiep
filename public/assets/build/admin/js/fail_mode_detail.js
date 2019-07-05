$(function(){
    'use strict';
    var table_dynamic_fail_mode_detail = $('.table-dynamic-fail-mode-detail').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_fail_mode_detail",
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
            {"data": "category_name", "searchable": false},
            {"data": "failure_mode", "searchable": false},
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
                targets: [-2],
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
    $('#category_id, #failure_id').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $('#category_id').on('select2:select', function (e) {
        $('#failure_id').parents('.row').removeClass('d-none');
        $('#FailModeDetailForm #failure_id').prop('required',true);
        $('#FailModeDetailForm').parsley().reset();
        var data = e.params.data;
        switchFunction('#failure_id', data.id);
    }).on('select2:unselect', function (e) {
        $('#failure_id').parents('.row').addClass('d-none');
        $('#FailModeDetailForm #failure_id').prop('required',false);
        $('#FailModeDetailForm').parsley().reset();
        $('#failure_id').empty();
    });
    $(document).on('click', '.table-dynamic-fail-mode-detail .table-action-delete', function (e) {
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
        DeleteFailureModeDetail(id, table_dynamic_fail_mode_detail);
    });
    $(document).on('click', '.table-dynamic-fail-mode-detail .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormFailureModeDetail(lang, 'edit');
        UpdateFailureModeDetail(id, lang);
    });
    $(document).on('click', '#addFailModeDetail', function (e) {
		e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormFailureModeDetail(lang, 'add');
        $('#failure_id').parents('.row').addClass('d-none');
		$('#modal-fail-mode-detail').modal('show');
    });
    $(document).on('click', '#btnFailModeDetail', function (e) {
        e.preventDefault();
        $('#FailModeDetailForm').submit();
    });
    $("#FailModeDetailForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            FailureModeDetailFormSubmit(table_dynamic_fail_mode_detail);
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
            var option = new Option(item.name+description, item.id, false, false);
            $('#category_id').append(option);
        })
    }).then(function () {
        $('#category_id').val('').trigger('change.select2');
    });
    $('#FailModeDetailForm').on('change input', function() {
        $('#modal-fail-mode-detail').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});

var category_id = '';
var switchFunction = function (ele, data) {
    $(ele).empty();
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_fail_mode?categoryId=" + data
    }).then(function (data) {
        $.map(data, function (item) {
            var option = new Option(item.m_falure_mode_translations.name, item.id, false, false);
            $(ele).append(option);
        })
    }).then(function (data) {
        $('#FailModeDetailForm #failure_id').val(category_id).trigger('change.select2');
    });
};

var ClearFormFailureModeDetail = function(lang, type) {
    $('#FailModeDetailForm')[0].reset();
    $('#FailModeDetailForm').parsley().reset();
    $('#modal-fail-mode-detail #lang').val(lang);
    $('#modal-fail-mode-detail #category_id').val('').trigger('change.select2');
    if (type == "add") {
        $('#modal-fail-mode-detail #ttlModal').html('Add failure mode detail');
        $('#modal-fail-mode-detail #action').val('insert');
        category_id = '';
        $('#FailModeDetailForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else {
        $('#modal-fail-mode-detail #ttlModal').html('Update failure mode detail');
        $('#modal-fail-mode-detail #action').val('update');
    }
    $('#modal-fail-mode-detail').find('button.btn-primary').prop('disabled', true);
};

var FailureModeDetailFormSubmit = function(table) {
    $('#btnFailModeDetail').attr('disabled', true);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_fail_mode_detail",
        type: "post",
        data: $('#FailModeDetailForm').serialize(),
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
                // $('#btnFailModeDetail').button('reset');
                $('#modal-fail-mode-detail').modal('hide');
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

var UpdateFailureModeDetail = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_fail_mode_detail?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                if (typeof response.data.m_falure_mode_detail_translations !== "undefined") {
                    $('#modal-fail-mode-detail #id').val(response.data.id);
                    $('#modal-fail-mode-detail #name').val(response.data.m_falure_mode_detail_translations.name);
                    $('#modal-fail-mode-detail #weight_factor').val(response.data.weight_factor);
                    $('#modal-fail-mode-detail #category_id').val(response.data.m_falure_mode.category_id).trigger('change.select2');
                    $('#modal-fail-mode-detail #failure_id').parents('.row').removeClass('d-none');
                    switchFunction('#failure_id', response.data.m_falure_mode.category_id);
                    category_id = response.data.falure_id;
                }

                $('#modal-fail-mode-detail').modal('show');
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
            $('#FailModeDetailForm').each(function() {
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

var DeleteFailureModeDetail = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_fail_mode_detail?action=delete&id=" + id,
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
