var table_dynamic_area;
$(function(){
    'use strict';
    // Select2
    loadDataTable('');
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#line_id, #line_id_modal').select2({
        minimumResultsForSearch: Infinity,
        allowClear: true
    });
    $('#line_id, #line_id_modal').on("select2:select", function (e) {
        var data = e.params.data;
        var line = data.id;
        loadDataTable(line);
    })
    $(document).on('click', '.table-dynamic-area .table-action-delete', function (e) {
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
        DeleteArea(id, table_dynamic_area);
    });
    $(document).on('click', '#addArea', function (e) {
		e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormArea(lang, 'add');
		$('#modal-area').modal('show');
    });
    $(document).on('click', '#addMore', function (e) {
		e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormArea(lang, 'insertlist');
		$('#modal-area').modal('show');
    });
	$(document).on('click', '#btnArea', function (e) {
        e.preventDefault();
        $('#AreaForm').submit();
    });
    $(document).on('click', '.table-dynamic-area .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormArea(lang, 'edit');
        UpdateArea(id, lang);
    });
    $("#AreaForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            AreaFormSubmit(table_dynamic_area);
        }
    });
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_line"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var option = new Option(item.name, item.id, false, false);
            $('#line_id_modal, #line_id').append(option);
        })
    });
    $('#AreaForm').on('change input', function() {
        $('#modal-area').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });

    
    $('#line_id').on('select2:unselect', function (e) {
        loadDataTable('');
    });
    $('#AreaForm').on('change input', function() {
        $('#modal-area').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});

var ClearFormArea = function(lang, type) {
    $('#AreaForm')[0].reset();
    $('#AreaForm').parsley().reset();
    $('#modal-area #lang').val(lang);
    $('#modal-area #line_id').val('').trigger('change.select2');
    if (type == "add") {
        $('#modal-area #ttlModal').html('Add area');
        $('#modal-area #action').val('insert');
        $('#modal-area #listname').parents('.row').addClass('d-none');
        $('#modal-area #name').parents('.row').removeClass('d-none');
        $('#modal-area #name').prop('required',true);
        $('#modal-area #listname').prop('required',false);
        site_id = '';
        $('#AreaForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else if(type == "insertlist"){
        $('#modal-area #ttlModal').html('Add list area');
        $('#modal-area #listname').parents('.row').removeClass('d-none');
        $('#modal-area #name').parents('.row').addClass('d-none');
        $('#modal-area #name').prop('required',false);
        $('#modal-area #listname').prop('required',true);
        $('#modal-area #listname').summernote('destroy');
        $('#modal-area #listname').val('');
        $('#modal-area #action').val(type);
    } else {
        $('#modal-area #ttlModal').html('Update area');
        $('#modal-area #listname').parents('.row').addClass('d-none');
        $('#modal-area #name').parents('.row').removeClass('d-none');
        $('#modal-area #name').prop('required',true);
        $('#modal-area #listname').prop('required',false);
        $('#modal-area #action').val('update');
    }
    $('#modal-area').find('button.btn-primary').prop('disabled', true);
};

var AreaFormSubmit = function(table) {
    $('#btnArea').attr('disabled', true);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_area",
        type: "post",
        data: $('#AreaForm').serialize(),
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
                // $('#btnArea').button('reset');
                $('#modal-area').modal('hide');
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

var UpdateArea = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_area?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                if (typeof response.data.m_area_translations !== "undefined") {
                    $('#modal-area #id').val(response.data.id);
                    $('#modal-area #name').val(response.data.m_area_translations.name);
                    $('#modal-area #line_id_modal').val(response.data.line_id).trigger('change.select2');
                    if(response.data.status) {
                        $('#modal-area #status').prop( "checked", true );
                    } else {
                        $('#modal-area #status').prop( "checked", false );
                    }
                }
                $('#modal-area').modal('show');
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
            $('#AreaForm').each(function() {
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

var DeleteArea = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_area?action=delete&id=" + id,
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

var loadDataTable = function (line) {
    if ($.fn.DataTable.isDataTable('.table-dynamic-area')) {
        $('.table-dynamic-area').DataTable().destroy();
        $('.table-dynamic-area tbody').empty();
    }
    table_dynamic_area = $('.table-dynamic-area').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_area?lineId="+line,
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
            {"data": "line_name", "searchable": false},
            {"data": "status", "searchable": false},
			{"data": "action", "searchable": false}
		],
		"columnDefs": [
            {
				targets: [0],
				class: 'text-center wd-100'
			},
            {
                orderable: false,
                targets: [1],
                class: 'multi-line wd-200'
            },
            {
                orderable: false,
                targets: [2],
                class: 'multi-line wd-200'
            },
            {
                orderable: false,
                targets: [3],
                class: 'multi-line wd-200'
            },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center wd-100'
			},
		]
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
};


