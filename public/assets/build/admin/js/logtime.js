$(function(){
    'use strict';
    var table_dynamic_logtime = $('.table-dynamic-logtime').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_logtime",
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
            {"data": "timein", "searchable": false},
            {"data": "timeout", "searchable": false},
		],
		"columnDefs": [
            {
				targets: [0],
                class: 'text-center',
                width: 100
			},
            {
                orderable: false,
                targets: [1,2,3],
                class: 'text-center'
            },
		]
    });

    $(document).on('click', '#exportLogtime', function (e) {
		e.preventDefault();
        $('#dataExportLogtime')[0].reset();
        $('#modal-export-logtime #ttlModal').html('Chọn khoảng thời gian')
		$('#modal-export-logtime').modal('show');
    });
    
    $('input[name="exportToDate"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        timePicker24Hour:false,
        locale: {
            format: 'YYYY-MM-DD hh:mm:ss'
        }
    });

    var exportToDate = $('#exportToDate').val();
    $('input[name="exportFromDate"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        timePicker24Hour:false,
        locale: {
          format: 'YYYY-MM-DD hh:mm:ss'
        },
        maxDate: moment(exportToDate, 'YYYY-MM-DD hh:mm:ss')
    });

    $('#exportToDate').change(function(){
        var exportToDate = $('#exportToDate').val();
        $('input[name="exportFromDate"]').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10),
            timePicker24Hour:false,
            locale: {
                format: 'YYYY-MM-DD hh:mm:ss'
            },
            maxDate: moment(exportToDate, 'YYYY-MM-DD hh:mm:ss')
        });
    });

    $(document).on('click','#exportLogtimeBtn',function(e){
        e.preventDefault();
        var fromDate = $('#exportFromDate').val();
        var toDate = $('#exportToDate').val();
        window.location= base_admin + "/home/ajax/exportlogtime?fromDate="+fromDate+"&toDate="+toDate ;
    });
});