var api_fileuploader;

$(function(){
    'use strict';
    var table_dynamic_user = $('.table-dynamic-user').DataTable({
		"processing": true,
		"ajax": "../../../../data/user.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "name"},
            {"data": "phone"},
			// {"data": "birthday"},
			{"data": "role"},
			// {"data": "manage"},
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
                            ' <span class="btn-action table-action-view cursor-pointer tx-info" data-id="' + data.id + '"><i' +
                            ' class="fa fa-eye"></i></span>';
				}
			},
			// {
			// 	targets: [-2],
			// 	class: 'text-center',
			// 	render: function (data, type, row, meta) {
			// 		if (data == 1) {
             //            return '<i class="fa fa-check-circle tx-success"></i>';
			// 		} else {
             //            return '';
			// 		}
			// 	}
			// }
		]
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    //Modal log
    var table_dynamic_log;
    $(document).on('click', '.table-dynamic-user .table-action-view', function (e) {
        e.preventDefault();
        $('#modal-log #ttlModal').html('List activities');
        var id = $(this).attr('data-id');
        if ($.fn.DataTable.isDataTable('.table-dynamic-log')) {
            $('.table-dynamic-log').DataTable().destroy();
        }
        table_dynamic_log = $('.table-dynamic-log').DataTable({
            "processing": true,
            "ajax": "../../../../data/activity.json",
            "responsive": true,
            "scrollX": true,
            "language": {
                searchPlaceholder: 'Search...',
                sSearch: ''
            },
            "columns": [
                {"data": "id"},
                {"data": "date"},
                {"data": "system"},
                {"data": "action"},
                {"data": "status"}
            ],
            "columnDefs": [
                {
                    targets: [0, 1, -1],
                    class: 'text-center'
                }
            ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
        $('#modal-log').modal('show');
    });

    //Add User
    $(document).on('click', '#addUser', function (e) {
        e.preventDefault();
        $('#modal-user #ttlModal').html('Add User');
        $('#modal-user').modal('show');
    });

    //Delete User
    $(document).on('click', '.table-dynamic-user .table-action-delete', function (e) {
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

    //Submit form
    $(document).on('click', '#btnUser', function (e) {
        e.preventDefault();
        $('#UserForm').submit();
    });
    $("#UserForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });

    //Modal Add User
    $('#role').select2({
        minimumResultsForSearch: Infinity
    }).on('select2:select', function (e) {
        var data = e.params.data;
        if(data.id == "1") {
            $('#areaMachine').prop('multiple', false).attr('name', 'areaMachine').select2({
                minimumResultsForSearch: Infinity
            });
        } else {
            $('#areaMachine').prop('multiple', true).attr('name', 'areaMachine[]').select2();
        }
    });
    $('#areaMachine').select2();
    $('.datepicker').mask('99/99/9999');
    // $('#phone').mask('(999) 999-9999');
    $("input[name='pass']:radio").change(function(){
        if($(this).val() == '1') {
            $('.block-pass-word').addClass('d-none');
        } else {
            $('.block-pass-word').removeClass('d-none');
        }
    });
    $(document).on('click', '#importUser', function (e) {
        e.preventDefault();
        $('#modal-import-user #ttlModal').html('Import User');
        $('#modal-import-user').modal('show');
    });

    if(typeof api_fileuploader !== 'undefined') {
        api_fileuploader.reset();
        api_fileuploader.destroy();
    }
    fileuploader();
});

var fileuploader = function () {
    if($('input.picupload').length > 0) {
        $('input.picupload').fileuploader({
            limit: 1,
            extensions: ['jpg', 'jpeg', 'png', 'gif'],
            changeInput: ' ',
            theme: 'thumbnails',
            enableApi: true,
            addMore: true,
            thumbnails: {
                box: '<div class="fileuploader-items">' + '<ul class="fileuploader-items-list">' + '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' + '</ul>' + '</div>',
                item: '<li class="fileuploader-item file-has-popup">' + '<div class="fileuploader-item-inner">' + '<div class="type-holder">${extension}</div>' + '<div class="actions-holder">' + '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' + '</div>' + '<div class="thumbnail-holder">' + '${image}' + '<span class="fileuploader-action-popup"></span>' + '</div>' + '<div class="content-holder"><h5>${name}</h5></div>' + '<div class="progress-holder">${progressBar}</div>' + '</div>' + '</li>',
                item2: '<li class="fileuploader-item file-has-popup">' + '<div class="fileuploader-item-inner">' + '<div class="type-holder">${extension}</div>' + '<div class="actions-holder">' + '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i></i></a>' + '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' + '</div>' + '<div class="thumbnail-holder">' + '${image}' + '<span class="fileuploader-action-popup"></span>' + '</div>' + '<div class="content-holder"><h5>${name}</h5></div>' + '<div class="progress-holder">${progressBar}</div>' + '</div>' + '</li>',
                startImageRenderer: true,
                canvasImage: true,
                _selectors: {
                    list: '.fileuploader-items-list',
                    item: '.fileuploader-item',
                    start: '.fileuploader-action-start',
                    retry: '.fileuploader-action-retry',
                    remove: '.fileuploader-action-remove'
                },
                onImageLoaded: function(item) {

                },
                onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));
                    plusInput.insertAfter(item.html)[((api.getOptions().limit && api.getAppendedFiles().length) || (api.getOptions().limit && api.getChoosedFiles().length)) >= api.getOptions().limit ? 'hide' : 'show']();
                    if (item.format == 'image') {
                        item.html.find('.fileuploader-item-icon').hide();
                    }
                },
                onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));
                    html.children().animate({
                        'opacity': 0
                    }, 200, function() {
                        setTimeout(function() {
                            html.remove();
                            if (api.getFiles().length - 1 < api.getOptions().limit) {
                                plusInput.show()
                            }
                        }, 100)
                    })
                }
            },
            dragDrop: {
                container: '.fileuploader-thumbnails-input'
            },
            editor: {
                cropper: {
                    ratio: '1:1',
                    minWidth: 128,
                    minHeight: 128,
                    showGrid: true
                }
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));
                plusInput.on('click', function() {
                    api.open()
                })
            }
        });
        api_fileuploader = $.fileuploader.getInstance('input.picupload');
    }
}
