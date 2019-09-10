$(function(){
    'use strict';
    var table_dynamic_notification = $('.table-dynamic-notification').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_notification",
        "responsive": true,
        "scrollX": true,
        "pagingType": "full_numbers",
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "creater"},
            {"data": "image"},
            {"data": "category"},
			{"data": "failure"},
            {"data": "status"},
			{"data": "action", "searchable": false}
		],
		"columnDefs": [
            {
				targets: [0],
				class: 'text-center'
			},
            {
                orderable: false,
                targets: [1],
                class: 'multi-line'
            },
            // {
            //     orderable: false,
            //     targets: [2],
            //     class: 'text-center'
            // },
            // {
            //     orderable: false,
            //     targets: [-2],
            //     class: 'multi-line'
            // },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center'
			}
		]
	});
});
