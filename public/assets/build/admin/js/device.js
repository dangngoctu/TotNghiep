var majorId, courseId, table_dynamic_device,majorId_filter, courseId_filter;
$(function(){
    'use strict';
    loadDataTable('','');
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_major"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var option = new Option(item.name, item.id, false, false);
            $('#major_id_filter, #major_id').append(option);
        })
    });
    $('#major_id_filter').on("select2:select", function (e) {
        $('#course_id_filter').parents('.col-sm-6').removeClass('d-none');
        var data_major_filter = e.params.data;
        majorId_filter = data_major_filter.id;
        $('#course_id_filter').empty();
        $('#course_id_filter').append('<option label="Select course"></option>');
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: base_admin + "/home/ajax/ajax_course?majorId="+majorId_filter,
        }).then(function (data) {
            $.map(data.data, function (item) {
                var option = new Option(item.name, item.id, false, false);
                $('#course_id_filter').append(option);
            })
        });
        loadDataTable(majorId_filter,'');
    }).on('select2:unselect', function (e) {
        $('#course_id_filter').parents('.col-sm-6').addClass('d-none');
        $('#course_id_filter').empty();
        loadDataTable('','');
    });

    $('#major_id').on("select2:select", function (e) {
        $('#course_id').parents('.row').removeClass('d-none');
        $('#course_id').empty();
        $('#course_id').append('<option label="Select course"></option>');
        var data_major = e.params.data;
        majorId = data_major.id;
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: base_admin + "/home/ajax/ajax_course?majorId="+majorId,
        }).then(function (data) {
            $.map(data.data, function (item) {
                var option = new Option(item.name, item.id, false, false);
                $('#course_id').append(option);
            })
        });
    }).on('select2:unselect', function (e) {
        $('#course_id').parents('.mg-t-30').addClass('d-none');
        $('#course_id').empty();
    });

    $(document).on('click', '.table-dynamic-device .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormDevice(lang, 'edit');
        UpdateDevice(id, lang);
    })

    $('#course_id_filter').on("select2:select", function (e) {
        var data_course_filter = e.params.data;
        courseId_filter = data_course_filter.id;
        loadDataTable(majorId_filter, courseId_filter);
    }).on('select2:unselect', function (e) {
        $('#course_id_filter').empty();
        loadDataTable(majorId,'');
    });
    // Select2
    $('#major_id, #course_id, #major_id_filter, #course_id_filter').select2({
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
        DeleteClass(id, table_dynamic_device);
    });
    $(document).on('click', '#addDevice', function (e) {
		e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormDevice(lang, 'add');
        $('#course_id').parents('.row').addClass('d-none');
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

var loadDataTable = function (majorId, courseId) {
    if ($.fn.DataTable.isDataTable('.table-dynamic-device')) {
        $('.table-dynamic-device').DataTable().destroy();
        $('.table-dynamic-device tbody').empty();
    }
    table_dynamic_device = $('.table-dynamic-device').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_class?majorId="+majorId+'&courseId='+courseId,
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
            {"data": "major_name", "searchable": false},
            {"data": "course_name", "searchable": false},
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
    $('#modal-device #course_id').val('').trigger('change.select2');
    $('#modal-device #major_id').val('').trigger('change.select2');
    if (type == "add") {
        $('#modal-device #ttlModal').html('Add class');
        $('#modal-device #action').val('insert');
        $('#modal-device #course_id').parents('.row').addClass('d-none');
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
        $('#modal-device #course_id').parents('.row').addClass('d-none');
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
        url: base_admin + "/home/ajax/ajax_class?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                if (typeof response.data.m_class_translations !== "undefined") {
                    $('#modal-device #id').val(response.data.id);
                    $('#modal-device #name').val(response.data.m_class_translations.name);
                    $('#modal-device #major_id').val(response.data.m_course.major_id).trigger('change.select2');
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: base_admin + "/home/ajax/ajax_course?majorId="+response.data.m_course.major_id,
                    }).then(function (data) {
                        $.map(data.data, function (item) {
                            var option = new Option(item.name, item.id, false, false);
                            $('#course_id').append(option);
                        })
                    }).then(function(e){
                        $('#modal-device #course_id').parents('.row').removeClass('d-none');
                        $('#modal-device #course_id').val(response.data.course_id).trigger('change.select2');
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
        url: base_admin + "/home/ajax/ajax_class",
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

var DeleteClass = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_class?action=delete&id=" + id,
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