var table_dynamic_news, api_fileuploader_icon;
$(function(){
    'use strict';
    table_dynamic_news = $('.table-dynamic-news').DataTable({
		"processing": true,
		"ajax": "../../../../data/news.json",
        "responsive": true,
        "scrollX": true,
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
        "dom": '<l<t>i>',
		"columns": [
			{"data": "id"},
			{"data": "name"},
            {"data": null, "searchable": false},
            {"data": null, "searchable": false},
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
			},
            {
                orderable: false,
                targets: [-2],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return '<i class="' + data.icon + ' tx-16"></i>';
                }
            },
            {
                orderable: false,
                targets: [-3],
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return  '<span><a data-id="' + data.id + '" class="upBtn btn-action tx-info"><i class="fa fa-caret-square-o-up"></i></a></span>' +
                            '<span class="mg-l-5"><a data-id="' + data.id + '" class="downBtn btn-action tx-info"><i class="fa fa-caret-square-o-down"></i></a></span>';
                }
            }
		],
        'drawCallback': function(){
            $('.table-dynamic-news tr:nth-child(1) .upBtn').remove();
            $('.table-dynamic-news tr:nth-child(1) .downBtn').parent().removeClass('mg-l-5');
            $('.table-dynamic-news tr:last .downBtn').remove();
            $('.table-dynamic-news tr:last .upBtn').parent().next().removeClass('mg-l-5');
            $('.upBtn').unbind('click');
            $('.downBtn').unbind('click');
            $('.upBtn').on('click', function(){
                moveUp($(this));
            });
            $('.downBtn').on('click', function(){
                moveDown($(this));
            });
        }
	});
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    if($('textarea').length > 0) {
        $('textarea').summernote({
            height: 300,                 // set editor height
            // minHeight: 300,             // set minimum height of editor
            // maxHeight: 500,             // set maximum height of editor
            tooltip: false
        });
        // $('div.note-group-select-from-files').remove();
    }
    $(document).on('click', '.table-dynamic-news .table-action-delete', function (e) {
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
    $(document).on('click', '#addNews', function (e) {
		e.preventDefault();
		$('#modal-news #ttlModal').html('Add news');
		$('#modal-news').modal('show');
    });
    $(document).on('click', '#btnNews', function (e) {
        e.preventDefault();
        $('#NewsForm').submit();
    });
    $("#NewsForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()){
            alert('valid');
        }
    });
    if(typeof api_fileuploader_icon !== 'undefined') {
        api_fileuploader_icon.reset();
        api_fileuploader_icon.destroy();
    }
    fileuploader('input#icon');
    // $('#icon').select2({
    //     templateSelection: iformat,
    //     templateResult: iformat,
    //     allowHtml: true
    // });
});

// function iformat(icon) {
//     var originalOption = icon.element;
//     return $('<span><i class="' + $(originalOption).attr('value') + '"></i> ' + $(originalOption).attr('value') + '</span>');
// }

var moveUp = function (element) {
    var fid = element.data('id');
    var tr = element.parents('tr');
    $.ajax({
        // url: base_admin + "/ajax/client?action=update&up=1&id=" + fid,
        // type: "post",
        success: function (response) {
            moveRow(tr, 'up');
            table_dynamic_news.ajax.reload(null, false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Thông báo',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: response.msg
            });
        }
    });
}

var moveDown = function (element) {
    var fid = element.data('id');
    var tr = element.parents('tr');
    $.ajax({
        // url: base_admin + "/ajax/client?action=update&down=1&id=" + fid,
        // type: "post",
        success: function (response) {
            moveRow(tr, 'down');
            table_dynamic_news.ajax.reload(null, false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Thông báo',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: response.msg
            });
        }
    });
}

var moveRow = function (row, direction) {
    var index = table_dynamic_news.row(row).index();

    var order = -1;
    if (direction === 'down') {
        order = 1;
    }

    var data1 = table_dynamic_news.row(index).data();
    data1.sort += order;

    var data2 = table_dynamic_news.row(index + order).data();
    data2.sort += -order;

    table_dynamic_news.row(index).data(data2);
    table_dynamic_news.row(index + order).data(data1);

    table_dynamic_news.draw(false);
}

var fileuploader = function (element) {
    if($(element).length > 0) {
        $(element).fileuploader({
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
        api_fileuploader_icon = $.fileuploader.getInstance('input#icon');
    }
}