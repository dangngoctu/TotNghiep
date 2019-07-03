$(function(){
    'use strict';
    var table_dynamic_divice = $('.table-dynamic-device').DataTable({
		"processing": true,
		"ajax": "../../data/device.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
			{"data": "device_code"},
            {"data": "area_code"},
            {"data": "area_code"},
            {"data": "area_code"},
			{"data": "area_code"},
            // {"data": "date_end"},
            {"data": "status"},
			{"data": null}
		],
		"columnDefs": [
            {
				targets: [0, 3],
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
							' class="fa fa-trash"></i></span>' +
                            ' <span class="btn-action table-action-print cursor-pointer tx-info" data-id="' + data.id + '"><i' +
                            ' class="fa fa-qrcode"></i></span>';
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
    $('.datepicker').mask('99/99/9999');
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#location-id, #section-id, #line-id, #area-id').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $('#location-id').on("change", function (e) {
        $('#section-id').parents('.row').removeClass('d-none');
        $('#line-id, #area-id').parents('.row').addClass('d-none');
    });
    $('#section-id').on("change", function (e) {
        $('#line-id').parents('.row').removeClass('d-none');
        $('#area-id').parents('.row').addClass('d-none');
    });
    $('#line-id').on("change", function (e) {
        $('#area-id').parents('.row').removeClass('d-none');
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
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
    });
    $(document).on('click', '#addDevice', function (e) {
		e.preventDefault();
        $('#modal-device #ttlModal').html('Add machine');
        $('#section-id, #line-id, #area-id').parents('.row').addClass('d-none');
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
            alert('valid');
        }
    });
});
