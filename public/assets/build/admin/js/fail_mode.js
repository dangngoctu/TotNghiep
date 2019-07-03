$(function(){
    'use strict';
    var table_dynamic_fail_mode = $('.table-dynamic-fail-mode').DataTable({
		"processing": true,
		"ajax": "../../data/fail_mode.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
            {"data": "category"},
            {"data": "category"},
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
    });
    $(document).on('click', '.table-dynamic-fail-mode .table-action-edit', function (e) {
        $('#modal-fail-mode #ttlModal').html('Update failure mode');
        $('#modal-fail-mode').modal('show');
    });
    $(document).on('click', '#addFailMode', function (e) {
		e.preventDefault();
        $('#modal-fail-mode #ttlModal').html('Add failure mode');
        $('#category-code').parents('.row').addClass('d-none');
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
            alert('valid');
        }
    });
});
