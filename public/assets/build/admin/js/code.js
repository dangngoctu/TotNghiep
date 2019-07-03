$(function(){
    'use strict';
    var table_dynamic_code = $('.table-dynamic-code').DataTable({
		"processing": true,
		"ajax": "../../../../data/qr_code.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
        "dom": '<l<t>ip>',
		"columns": [
			{"data": "id"},
			{"data": null},
			{"data": "created_day"},
			{"data": null}
		],
		"columnDefs": [
            {
				targets: [0, 2],
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
                targets: [1],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return '<img src=' + data.img + ' rel="nofollow" alt="qr code"/>';
                }
            }
		]
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(document).on('click', '.table-dynamic-code .table-action-delete', function (e) {
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
    $(document).on('click', '#addCode', function (e) {
		e.preventDefault();
		$('#modal-code #ttlModal').html('Add QR code');
		$('#modal-code').modal('show');
    });
    $(document).on('click', '#btnCode', function (e) {
        e.preventDefault();
        $('#CodeForm').submit();
    });
    $("#CodeForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
