$(function(){
    'use strict';
    var table_dynamic_role = $('.table-dynamic-role').DataTable({
		"processing": true,
		"ajax": "../../data/role.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
            {"data": "username"},
			{"data": "name"},
			{"data": "description"},
			{"data": null}
		],
		"columnDefs": [
            {
				targets: [0, 1],
				class: 'text-center'
			},
			{
				orderable: false,
				targets: [-1],
				class: 'text-center',
				render: function (data, type, row, meta) {
					return  ' <span class="btn-action table-action-edit cursor-pointer tx-success" data-id="' + data.id + '"><i' +
							' class="fa fa-edit"></i></span>' +
							' <span class="btn-action table-action-delete cursor-pointer tx-danger" data-id="' + data.id + '"><i' +
							' class="fa fa-trash"></i></span>';
				}
			}
		]
	});
    var table_dynamic_permission = $('.table-dynamic-permission').DataTable({
        "processing": true,
        "ajax": "../../data/permission.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
        "columns": [
            {"data": "function"},
            {"data": null}
        ],
        "columnDefs": [
            {
                orderable: false,
                targets: [1],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return '<label class="ckbox d-inline-block">' +
                            '<input type="checkbox" name="all" class="all" data-id="' + data.add + '">' +
                            '<span></span>' +
                            '</label>';
                }
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
        $('#confirm-delete-modal #id').val(id);
        $('#confirm-delete-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
    });
    $(document).on('click', '#addRole', function (e) {
		e.preventDefault();
        $('#modal-role #ttlModal').html('Add Role');
		$('#modal-role').modal('show');
    });
	$(document).on('click', '#btnRole', function (e) {
        e.preventDefault();
        $('#RoleForm').submit();
    });
    $("#RoleForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
