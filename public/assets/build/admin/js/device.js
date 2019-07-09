var majorId, courseId, table_dynamic_device;
$(function(){
    'use strict';
    loadDataTable('','');
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_major"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var option = new Option(item.name, item.id, false, false);
            $('#major_id_filter').append(option);
        })
    });
    $('#major_id_filter').on("select2:select", function (e) {
        $('#course_id_filter').parents('.col-sm-6').removeClass('d-none');
        var data_major = e.params.data;
        majorId = data_major.id;
        $('#course_id_filter').empty();
        $('#course_id_filter').append('<option label="Select course"></option>');
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: base_admin + "/home/ajax/ajax_course?majorId="+majorId,
        }).then(function (data) {
            $.map(data.data, function (item) {
                var option = new Option(item.name, item.id, false, false);
                $('#course_id_filter').append(option);
            })
        });
        loadDataTable(majorId,'');
    }).on('select2:unselect', function (e) {
        $('#course_id_filter').parents('.col-sm-6').addClass('d-none');
        $('#course_id_filter').empty();
        loadDataTable('','');
    });

    $('#course_id_filter').on("select2:select", function (e) {
        var data_course = e.params.data;
        courseId = data_course.id;
        loadDataTable(majorId, courseId);
    }).on('select2:unselect', function (e) {
        $('#course_id_filter').empty();
        loadDataTable(majorId,'');
    });
    // Select2
    $('#major_id, #course_id, #major_id_filter, #course_id_filter').select2({
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
    $('#DeviceForm').on('change input', function() {
        $('#modal-device').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
});

var loadDataTable = function (majorId, courseId) {
    if ($.fn.DataTable.isDataTable('.table-dynamic-device')) {
        $('.table-dynamic-device').DataTable().destroy();
        $('.table-dynamic-device tbody').empty();
    }
    var table_dynamic_device = $('.table-dynamic-device').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_class?majorId="+majorId+'&courseId='+courseId,
        "responsive": true,
        "scrollX": true,
        "pagingType": "full_numbers",
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
            {"data": "major_name", "searchable": false},
            {"data": "course_name", "searchable": false},
            {"data": "status", "searchable": false},
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
                class: 'multi-line wd-200'
            },
            {
                orderable: false,
                targets: [2],
                class: 'multi-line wd-200'
            },
            {
                orderable: false,
                targets: [3],
                class: 'multi-line wd-200'
            },
            {
                orderable: false,
                targets: [4],
                class: 'multi-line wd-200'
            },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center wd-100'
			},
		]
    });
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
};