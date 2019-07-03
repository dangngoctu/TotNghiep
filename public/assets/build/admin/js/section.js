$(function(){
    'use strict';
    var table_dynamic_section = $('.table-dynamic-section').DataTable({
		"processing": true,
		"ajax": "../../data/section.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
			{"data": "location_id"},
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
    $('#location-id, #group-category-id').select2({
        minimumResultsForSearch: Infinity
    });
    $(document).on('click', '.table-dynamic-section .table-action-delete', function (e) {
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
    $(document).on('click', '#addSection', function (e) {
		e.preventDefault();
        $('#modal-section #ttlModal').html('Add Section');
		$('#modal-section').modal('show');
    });
	$(document).on('click', '#btnSection', function (e) {
        e.preventDefault();
        $('#SectionForm').submit();
    });
    $("#SectionForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
