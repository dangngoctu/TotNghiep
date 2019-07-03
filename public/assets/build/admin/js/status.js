$(function(){
    'use strict';
    var table_dynamic_status = $('.table-dynamic-status').DataTable({
		"processing": true,
		"ajax": "../../data/status.json",
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
    $(document).on('click', '.table-dynamic-status .table-action-delete', function (e) {
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
    $(document).on('click', '.table-dynamic-status .table-action-edit', function (e) {
        $('#modal-status #ttlModal').html('Cập nhật trạng thái');
        $('#modal-status').modal('show');
    });
    $(document).on('click', '#addStatus', function (e) {
		e.preventDefault();
        $('#modal-status #ttlModal').html('Thêm trạng thái');
		$('#modal-status').modal('show');
    });
    $(document).on('click', '#btnStatus', function (e) {
        e.preventDefault();
        $('#StatusForm').submit();
    });
    $("#StatusForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
});
