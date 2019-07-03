var api_fileuploader, card, count;

$(function(){
    'use strict';
    var table_dynamic_notify = $('.table-dynamic-notify').DataTable({
		"processing": true,
		"ajax": "../../../../data/notify.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
			{"data": "area"},
            {"data": "area"},
            {"data": "priority"},
            {"data": "status"},
			{"data": "status"},
			{"data": "time_created"},
			{"data": null},
            {"data": null}
		],
		"columnDefs": [
            {
				targets: [0, 3, 4, 5, 6],
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
				targets: [4],
				class: 'text-center',
				render: function (data, type, row, meta) {
				    switch (data)
                    {
                        case 2:
                            return  '<label class="excellent">' +
                                        '<input name="evaluation_excellent" type="radio" value="2" checked>' +
                                        '<span>Excellent</span>' +
                                    '</label>';
                        case 1:
                            return  '<label class="good">' +
                                        '<input name="evaluation_good" type="radio" value="1" checked>' +
                                        '<span>Good</span>' +
                                    '</label>';
                        case -1:
                            return  '<label class="poor">' +
                                        '<input name="evaluation_poor" type="radio" value="-1" checked>' +
                                        '<span>Poor</span>' +
                                    '</label>';
                        case -2:
                            return  '<label class="very_poor">' +
                                        '<input name="evaluation_very_poor" type="radio" value="-2" checked>' +
                                        '<span>Very Poor</span>' +
                                    '</label>';
                        default:
                            return  '<label class="average">' +
                                        '<input name="evaluation_average" type="radio" value="0" checked>' +
                                        '<span>Average</span>' +
                                    '</label>';
                    }
				}
			},
            {
                targets: [5],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    switch (data)
                    {
                        case 1:
                            return '<span class="badge badge-pill badge-info">Submitted</span>';
                        case 2:
                            return '<span class="badge badge-pill badge-warning">Seen</span>';
                        case 3:
                            return '<span class="badge badge-pill badge-danger">Done</span>';
                        case 4:
                            return '<span class="badge badge-pill badge-primary">Checked</span>';
                        default:
                            return 'Locked';
                    }
                }
            },
            {
                orderable: false,
                targets: [-1],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return  ' <span class="btn-action table-action-view cursor-pointer tx-info" data-id="' + data.id + '"><i' +
                            ' class="fa fa-eye"></i></span>';
                }
            }
		],
        'drawCallback': function(){
            if ($('.table-dynamic-notify input[type="radio"]').length > 0) {
                $('.table-dynamic-notify input[type="radio"]').iCheck({
                    radioClass: 'iradio_minimal-blue'
                });
            }
        }
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#location-id, #section-id, #line-id').select2({
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
    $('#timeDone').timepicker({'scrollDefault': 'now'});
    $(document).on('click', '.table-dynamic-notify .table-action-delete', function (e) {
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
    $(document).on('click', '.table-dynamic-notify .table-action-view', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#modal-view-notify').modal('show');
        $('#modal-view-notify #ttlModal').html('Info notification');
    });
    $(document).on('click', '#addNotify', function (e) {
		e.preventDefault();
		$('#modal-notify').modal('show');
    });
    $(document).on('click', '#btnNotify', function (e) {
        e.preventDefault();
        $('#NotifyForm').submit();
    });
    $("#NotifyForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            alert('valid');
        }
    });
    $(document).on('show.bs.modal', '#modal-notify', function (e) {
        clear_form();
        if(typeof api_fileuploader !== 'undefined') {
            api_fileuploader.reset();
            api_fileuploader.destroy();
        }
        if ($('#modal-notify select.select2').hasClass("select2-hidden-accessible")) {
            $('#modal-notify select.select2').select2('destroy');
        }
        card = $('#failureMode').clone();
        $('#modal-notify select.select2').select2({
            minimumResultsForSearch: Infinity
        });
        fileuploader('input.picupload');
        $('.block-failure-mode').find('.row:first-child').find('.remove-failure-mode').hide();
    });
    $(document).on('click', '.add-failure-mode', function (e) {
        $('.block-failure-mode').append($(card).html());
        count = $('.block-failure-mode').find('.row').length;
        show_hide_btn(count);
        var last_child = $('.block-failure-mode').find('.row')[count-1];
        $(last_child).find('select.select2').select2({
            minimumResultsForSearch: Infinity
        });
        fileuploader($(last_child).find('input.picupload'));
    });
    $(document).on('click', '.remove-failure-mode', function (e) {
        $(this).parents('.row')[0].remove();
        count = $('.block-failure-mode').find('.row').length;
        show_hide_btn(count);
    });
    if ($('input[type="radio"]').length > 0) {
        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
    }
});

var fileuploader = function (element) {
    if($(element).length > 0) {
        $(element).fileuploader({
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
};

var show_hide_btn = function (number) {
    switch (number) {
        case 1:
            $('.block-failure-mode').find('.row:first-child').find('.add-failure-mode').show();
            $('.block-failure-mode').find('.row:first-child').find('.remove-failure-mode').hide();
            break;
        case 2:
            $('.block-failure-mode').find('.row:first-child').find('.add-failure-mode').hide();
            $('.block-failure-mode').find('.row:nth-child(2)').find('.add-failure-mode, .remove-failure-mode').show();
            break;
        default:
            $('.block-failure-mode').find('.row:nth-child(3), .row:nth-child(2)').find('.add-failure-mode').hide();
            $('.block-failure-mode').find('.row:nth-child(3)').find('.remove-failure-mode').show();
    }
};

var clear_form = function () {
    $('#modal-notify #ttlModal').html('Add notification');
    $('.block-failure-mode').find('.row:not(:first-child)').remove();
    $('#NotifyForm')[0].reset();
    count = $('.block-failure-mode').find('.row').length;
    show_hide_btn(count);
};