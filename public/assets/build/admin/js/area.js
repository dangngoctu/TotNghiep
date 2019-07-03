$(function(){
    'use strict';
    var table_dynamic_area = $('.table-dynamic-area').DataTable({
		"processing": true,
		"ajax": "../../data/area.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
			// {"data": "area_code"},
            {"data": "line_id"},
            {"data": "line_id"},
			{"data": "line_id"},
            {"data": "status"},
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
			},
			{
				targets: [-2],
				class: 'text-center',
				render: function (data, type, row, meta) {
					if (data == 1) {
                        return '<i class="fa fa-check-circle tx-success"></i>';
					} else {
                        return '';
					}
				}
			}
		]
	});
    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#location-id, #section-id, #line-id').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $('#location-id').on("change", function (e) {
        $('#section-id').parents('.row').removeClass('d-none');
        $('#line-id').parents('.row').addClass('d-none');
    });
    $('#section-id').on("change", function (e) {
        $('#line-id').parents('.row').removeClass('d-none');
    });
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
    });
    $(document).on('click', '#addArea', function (e) {
		e.preventDefault();
        $('#modal-area #ttlModal').html('Add area');
        $('#section-id, #line-id').parents('.row').addClass('d-none');
		$('#modal-area').modal('show');
    });
	$(document).on('click', '#btnArea', function (e) {
        e.preventDefault();
        $('#AreaForm').submit();
    });
    $("#AreaForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
