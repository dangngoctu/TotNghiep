$(function(){
    'use strict';
    $('#modal-role').on( 'shown.bs.modal', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        $('.table-dynamic-permission').DataTable().search('').draw();
    });
    var table_dynamic_role = $('.table-dynamic-role').DataTable({
		"processing": true,
        "serverSide": true,
		"ajax": base_admin+"/home/ajax/ajax_role",
        "responsive": true,
        "scrollX": true,
        "pagingType": "full_numbers",
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
            {"data": "role", "searchable": false},
			{"data": "name"},
			{"data": "description", "searchable": false},
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
                class: 'multi-line wd-500'
            },
            {
                orderable: false,
                targets: [2],
                class: 'multi-line wd-500'
            },
            {
                orderable: false,
                targets: [3],
                class: 'multi-line wd-500'
            },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center wd-100'
			}
		]
	});
    var table_dynamic_permission = $('.table-dynamic-permission').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": base_admin+"/home/ajax/ajax_get_permission",
        "responsive": true,
        "scrollX": true,
        "paging" : false,
        "pagingType": "full_numbers",
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
        "columns": [
			{"data": "name"},
			{"data": "action"}
		],
		"columnDefs": [
            {
                orderable: false,
                targets: [1],
                class: 'text-center'
            }
		]
    });
    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    // $('.select2').select2({
    //     minimumResultsForSearch: Infinity
    // });
    $(document).on('click', '.table-dynamic-role .table-action-delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        ClearForm(id, 'delete');
        $('#confirm-delete-modal #id').val(id);
        $('#confirm-delete-modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#confirm-delete', function (e) {
            RoleFormSubmit(table_dynamic_role)
        });
    });

    $(document).on('click', '.table-action-edit', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        ClearForm(id, 'update');
		UpdateRole(id);
    });

    $(document).on('click', '#addRole', function (e) {
		e.preventDefault();
        ClearForm('', 'insert');
		$('#modal-role').modal('show');
    });
	$(document).on('click', '#btnRole', function (e) {
        e.preventDefault();
        dataArr = [];
        $('#modal-role #permission').val('');
        $('.table-dynamic-permission tr').filter(':has(:checkbox:checked)').each(function(i,item) {      
            dataArr.push($(item).find('td').eq(1).find('input').attr('data-id'));  
        });
        $('#modal-role #permission').val(dataArr.toString());
        $('#RoleForm').submit();
    });
    $("#RoleForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            RoleFormSubmit(table_dynamic_role)
        }
    });
    $('#RoleForm').on('change input', function() {
        $('#modal-role').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});
var dataArr = [];
var ClearForm = function(id, type) {
    $('#RoleForm')[0].reset();
    $('#RoleForm').parsley().reset();
    $('#modal-role #id').val(id);
    $('#modal-role #action').val(type);
    $('#modal-role #multiple_management').prop('checked',false);
    if (type == "insert") {
        $('#modal-role #ttlModal').html('Add Role');
        $('#modal-role #name').removeAttr('disabled', 'disabled');
        $('#RoleForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
	} else {
        $('#modal-role #ttlModal').html('Edit Role');
        $('#modal-role #name').attr('disabled', 'disabled');
    }
    $('#modal-role').find('button.btn-primary').prop('disabled', true);
}

var UpdateRole = function(id) {
    $.ajax({
        url: base_admin+"/home/ajax/ajax_role?id="+id,
        type: "get",
        success: function(response) {
			if (response.code == '200') {
				if (Object.keys(response.data).length > 0) {
                    $('#modal-role #name').val(response.data.name);
                    $('#modal-role #display_name').val(response.data.display_name);
                    $('#modal-role #description').val(response.data.description);
                    if(response.data.multiple_management == 1){
                        $('#modal-role #multiple_management').prop('checked',true);
                    } else {
                        $('#modal-role #multiple_management').prop('checked',false);
                    }
                    $.each(response.data.permissions, function(i, item) {
                        $('#modal-role #permission_'+item.id).prop('checked',true);
                    })
				}
				$('#modal-role').modal('show');
			} else {
                //error
			}
            $('#RoleForm').each(function() {
                $(this).data('serialized', $(this).serialize())
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
			//error
		}
    });
}

var RoleFormSubmit = function(table) {
    var form_data = new FormData($('#RoleForm')[0]);
    $('#btnRole').attr('disabled', true);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
		cache:false,
		contentType: false,
		enctype: 'multipart/form-data',
		processData: false,
		dataType: "json",
		type: "post",
		url: base_admin+"/home/ajax/ajax_role",
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
                $('#modal-role').modal('hide');
                $('#confirm-delete-modal').modal('hide');
                location.reload();
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
