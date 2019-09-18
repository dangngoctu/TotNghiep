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
});