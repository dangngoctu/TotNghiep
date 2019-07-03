$(function(){
    'use strict';
    var table_dynamic_group_category = $('.table-dynamic-group-category').DataTable({
		"processing": true,
		"ajax": "../../data/group_category.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
			{"data": null}
		],
		"columnDefs": [
            {
				targets: [0],
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
    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(document).on('click', '.table-dynamic-group-category .table-action-delete', function (e) {
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
    $(document).on('click', '.table-dynamic-group-category .table-action-edit', function (e) {
        $('#modal-group-category #ttlModal').html('Update category');
        $('#modal-group-category').modal('show');
    });
    $(document).on('click', '#addGroupCategory', function (e) {
		e.preventDefault();
        $('#modal-group-category #ttlModal').html('Add group category');
		$('#modal-group-category').modal('show');
    });
    $(document).on('click', '#btnGroupCategory', function (e) {
        e.preventDefault();
        $('#GroupCategoryForm').submit();
    });
    $("#GroupCategoryForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
