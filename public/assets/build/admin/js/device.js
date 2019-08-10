var lineId, areaId, table_dynamic_device,lineId_filter, areaId_filter;
$(function(){
    'use strict';
    loadDataTable('','');
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_line"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var option = new Option(item.name, item.id, false, false);
            $('#line_id_filter, #line_id').append(option);
        })
    });
    $('#line_id_filter').on("select2:select", function (e) {
        $('#area_id_filter').parents('.col-sm-6').removeClass('d-none');
        var data_line_filter = e.params.data;
        lineId_filter = data_line_filter.id;
        $('#area_id_filter').empty();
        $('#area_id_filter').append('<option label="Select area"></option>');
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: base_admin + "/home/ajax/ajax_area?lineId="+lineId_filter,
        }).then(function (data) {
            $.map(data.data, function (item) {
                var option = new Option(item.name, item.id, false, false);
                $('#area_id_filter').append(option);
            })
        });
        loadDataTable(lineId_filter,'');
    }).on('select2:unselect', function (e) {
        $('#area_id_filter').parents('.col-sm-6').addClass('d-none');
        $('#area_id_filter').empty();
        loadDataTable('','');
    });

    $('#line_id').on("select2:select", function (e) {
        $('#area_id').parents('.row').removeClass('d-none');
        $('#area_id').empty();
        $('#area_id').append('<option label="Select area"></option>');
        var data_line = e.params.data;
        lineId = data_line.id;
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: base_admin + "/home/ajax/ajax_area?lineId="+lineId,
        }).then(function (data) {
            $.map(data.data, function (item) {
                var option = new Option(item.name, item.id, false, false);
                $('#area_id').append(option);
            })
        });
    }).on('select2:unselect', function (e) {
        $('#area_id').parents('.mg-t-30').addClass('d-none');
        $('#area_id').empty();
    });

    $(document).on('click', '.table-dynamic-device .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormDevice(lang, 'edit');
        UpdateDevice(id, lang);
    })

    $('#area_id_filter').on("select2:select", function (e) {
        var data_area_filter = e.params.data;
        areaId_filter = data_area_filter.id;
        loadDataTable(lineId_filter, areaId_filter);
    }).on('select2:unselect', function (e) {
        $('#area_id_filter').empty();
        loadDataTable(lineId,'');
    });
    // Select2
    $('#line_id, #area_id, #line_id_filter, #area_id_filter').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $(document).on('click', '.table-dynamic-device .table-action-delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#confirm-delete-modal #id').val(id);
        $('#confirm-delete-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    $(document).on('click', '#addMore', function (e) {
		e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormDevice(lang, 'insertlist');
		$('#modal-device').modal('show');
    });
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
        DeleteDevice(id, table_dynamic_device);
    });
    $(document).on('click', '#addDevice', function (e) {
		e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormDevice(lang, 'add');
        $('#area_id').parents('.row').addClass('d-none');
		$('#modal-device').modal('show');
    });
	$(document).on('click', '#btnDevice', function (e) {
        e.preventDefault();
        $('#DeviceForm').submit();
    });
    $("#DeviceForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            DeviceFormSubmit(table_dynamic_device);
        }
    });
    $('#DeviceForm').on('change input', function() {
        $('#modal-device').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});

var loadDataTable = function (lineId, areaId) {
    if ($.fn.DataTable.isDataTable('.table-dynamic-device')) {
        $('.table-dynamic-device').DataTable().destroy();
        $('.table-dynamic-device tbody').empty();
    }
    table_dynamic_device = $('.table-dynamic-device').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_device?lineId="+lineId+'&areaId='+areaId,
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
            {"data": "area_name", "searchable": false},
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
                targets: [4],
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

var ClearFormDevice = function(lang, type) {
    $('#DeviceForm')[0].reset();
    $('#DeviceForm').parsley().reset();
    $('#modal-device #lang').val(lang);
    $('#modal-device #area_id').val('').trigger('change.select2');
    $('#modal-device #line_id').val('').trigger('change.select2');
    if (type == "add") {
        $('#modal-device #ttlModal').html('Add device');
        $('#modal-device #action').val('insert');
        $('#modal-device #area_id').parents('.row').addClass('d-none');
        $('#modal-device #listname').parents('.row').addClass('d-none');
        $('#modal-device #name').parents('.row').removeClass('d-none');
        $('#modal-device #name').prop('required',true);
        $('#modal-device #listname').prop('required',false);
        site_id = '';
        $('#DeviceForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else if(type == "insertlist"){
        $('#modal-device #ttlModal').html('Add list class');
        $('#modal-device #listname').parents('.row').removeClass('d-none');
        $('#modal-device #name').parents('.row').addClass('d-none');
        $('#modal-device #name').prop('required',false);
        $('#modal-device #listname').prop('required',true);
        $('#modal-device #listname').summernote('destroy');
        $('#modal-device #listname').val('');
        $('#modal-device #area_id').parents('.row').addClass('d-none');
        $('#modal-device #action').val(type);
    } else {
        $('#modal-device #ttlModal').html('Update Class');
        $('#modal-device #action').val('update');
        $('#modal-device #device_code').parents('.row').removeClass('d-none');
        $('#modal-device #device_code').prop('required',true);
        $('#modal-device #listname').parents('.row').addClass('d-none');
        $('#modal-device #listname').prop('required',false);
    }
    $('#modal-device').find('button.btn-primary').prop('disabled', true);
};

var UpdateDevice = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_device?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                if (typeof response.data.m_device_translations !== "undefined") {
                    $('#modal-device #id').val(response.data.id);
                    $('#modal-device #name').val(response.data.m_device_translations.name);
                    $('#modal-device #line_id').val(response.data.m_area.line_id).trigger('change.select2');
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: base_admin + "/home/ajax/ajax_area?lineId="+response.data.m_area.line_id,
                    }).then(function (data) {
                        $.map(data.data, function (item) {
                            var option = new Option(item.name, item.id, false, false);
                            $('#area_id').append(option);
                        })
                    }).then(function(e){
                        $('#modal-device #area_id').parents('.row').removeClass('d-none');
                        $('#modal-device #area_id').val(response.data.area_id).trigger('change.select2');
                    });
                    if(response.data.status) {
                        $('#modal-device #status').prop( "checked", true );
                    } else {
                        $('#modal-device #status').prop( "checked", false );
                    }
                }
                $('#modal-device').modal('show');
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
            $('#DeviceForm').each(function() {
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

var DeviceFormSubmit = function(table) {
    $('#btnDevice').attr('disabled', true);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_device",
        type: "post",
        data: $('#DeviceForm').serialize(),
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
                $('#modal-device').modal('hide');
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

var DeleteDevice = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_device?action=delete&id=" + id,
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