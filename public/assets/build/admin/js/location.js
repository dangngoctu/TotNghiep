$(function(){
    'use strict';
    var table_dynamic_location = $('.table-dynamic-location').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_line",
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
            // {"data": "name", "searchable": false},
            // {"data": "point", "searchable": false},
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
            // {
            //     orderable: false,
            //     targets: [2],
            //     class: 'text-center'
            // },
            // {
            //     orderable: false,
            //     targets: [-2],
            //     class: 'multi-line'
            // },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center'
			}
		]
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(document).on('click', '.table-dynamic-location .table-action-delete', function (e) {
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
        DeleteLocation(id, table_dynamic_location);
    });
    $(document).on('click', '.table-dynamic-location .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormLocation(lang, 'edit');
        UpdateLocation(id, lang);
    });
    $(document).on('click', '#addLocation', function (e) {
		e.preventDefault();
        $('#LocationForm')[0].reset();
        var lang = $(this).attr('data-lang');
        ClearFormLocation(lang, 'add');
		$('#modal-location').modal('show');
    });
    $(document).on('click', '#btnLocation', function (e) {
        e.preventDefault();
        $('#LocationForm').submit();
    });
    $("#LocationForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            LocationFormSubmit(table_dynamic_location);
        }
    });
    $('#LocationForm').on('change input', function() {
        $('#modal-location').find('button:button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
    $('#modal-location').on('hidden.bs.modal', function (e) {
        $('#draw-button').trigger('click');
    });
});

var LocationFormSubmit = function(table) {
    $('#btnLocation').attr('disabled', true);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_line",
        type: "post",
        data: $('#LocationForm').serialize(),
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
                $('#modal-location').modal('hide');
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

var UpdateLocation = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_line?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                if (typeof response.data.m_line_translations !== "undefined") {
                    $('#modal-location #id').val(response.data.id);
                    $('#modal-location #name').val(response.data.m_line_translations.name);
                    if(response.data.status) {
                        $('#modal-location #status').prop( "checked", true );
                    } else {
                        $('#modal-location #status').prop( "checked", false );
                    }
                }

                $('#modal-location').modal('show');
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
            $('#LocationForm').each(function() {
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

var DeleteLocation = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_line?action=delete&id=" + id,
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

var ClearFormLocation = function(lang, type) {
    $('#LocationForm')[0].reset();
    $('#LocationForm').parsley().reset();
    $('#modal-location #lang').val(lang);
    if (type == "add") {
        $('#modal-location #ttlModal').html('Add line');
        $('#modal-location #action').val('insert');
        $('#LocationForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else {
        $('#modal-location #ttlModal').html('Update line');
        $('#modal-location #action').val('update');
    }
    $('#modal-location').find('button.btn-primary').prop('disabled', true);
};