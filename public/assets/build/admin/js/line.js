$(function(){
    'use strict';
    var table_dynamic_line = $('.table-dynamic-line').DataTable({
		"processing": true,
		"ajax": "../../data/line.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
			{"data": "section_id"},
            {"data": "section_id"},
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
    $('#location-id, #section-id').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $('#location-id').on("change", function (e) {
        $('#section-id').parents('.row').removeClass('d-none');
    });
    $(document).on('click', '.table-dynamic-line .table-action-delete', function (e) {
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
    $(document).on('click', '#addLine', function (e) {
		e.preventDefault();
        $('#modal-line #ttlModal').html('Add line');
        $('#section-id').parents('.row').addClass('d-none');
		$('#modal-line').modal('show');
    });
	$(document).on('click', '#btnLine', function (e) {
        e.preventDefault();
        $('#LineForm').submit();
    });
    $("#LineForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
