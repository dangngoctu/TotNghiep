var api_fileuploader;

$(function(){
    'use strict';
    var table_dynamic_notify_system = $('.table-dynamic-notify-system').DataTable({
		"processing": true,
		"ajax": "../../../../data/notify_system.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "area"},
            {"data": "priority"},
			{"data": "status"},
			{"data": "time_created"},
			{"data": "time_done"},
            {"data": null},
			{"data": null}
		],
		"columnDefs": [
            {
				targets: [0, 2, 3, 4, 5],
				class: 'text-center'
			},
            {
                orderable: false,
                targets: [-2],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return '<label class="ckbox d-inline-block">' +
                        '<input type="checkbox" name="all" class="all" data-id="' + data.add + '">' +
                        '<span></span>' +
                        '</label>';
                }
            },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center',
				render: function (data, type, row, meta) {
					return  ' <span class="btn-action table-action-view cursor-pointer tx-info" data-id="' + data.id + '"><i' +
                            ' class="fa fa-eye"></i></span>';
                            // ' <span class="btn-action table-action-edit cursor-pointer tx-success" data-id="' + data.id + '"><i' +
							// ' class="fa fa-edit"></i></span>' +
							// ' <span class="btn-action table-action-delete cursor-pointer tx-danger" data-id="' + data.id + '"><i' +
							// ' class="fa fa-trash"></i></span>';
				}
			},
			{
				targets: [3],
				class: 'text-center',
				render: function (data, type, row, meta) {
				    switch (data)
                    {
                        case 0:
                            return '<span class="badge badge-pill badge-danger">No audit</span>';
                        default:
                            return '<span class="badge badge-pill badge-danger">Done audit</span>';
                    }
				}
			}
		]
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#priority, #area-code, #evaluation, #fail_mode, #status, #category-code, #location-id, #section-id, #line-id').select2({
        minimumResultsForSearch: Infinity
    });
    if($('textarea').length > 0) {
        $('textarea').summernote({
            height: 300,                 // set editor height
            // minHeight: 300,             // set minimum height of editor
            // maxHeight: 500,             // set maximum height of editor
            tooltip: false
        });
        // $('div.note-group-select-from-files').remove();
    }
    $('.datepicker').mask('99/99/9999');
    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $('#timeAudit').timepicker({'scrollDefault': 'now'});
    $(document).on('click', '.table-dynamic-notify-system .table-action-delete', function (e) {
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
    $(document).on('click', '#addNotifySystem', function (e) {
		e.preventDefault();
		$('#modal-notify-system #ttlModal').html('Add notification schedule');
		$('#modal-notify-system').modal('show');
    });
    $(document).on('click', '.table-dynamic-notify-system .table-action-view', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#modal-view-notify-system #ttlModal').html('Info notification schedule');
        $('#modal-view-notify-system').modal('show');
    });
    $(document).on('click', '#btnNotifySystem', function (e) {
        e.preventDefault();
        $('#NotifySystemForm').submit();
    });
    $("#NotifySystemForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
    if(typeof api_fileuploader !== 'undefined') {
        api_fileuploader.reset();
        api_fileuploader.destroy();
    }
    fileuploader();
    if ($('input[type="radio"]').length > 0) {
        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
    }
});

var fileuploader = function () {
    if($('input.picupload').length > 0) {
        $('input.picupload').fileuploader({
            limit: 3,
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
