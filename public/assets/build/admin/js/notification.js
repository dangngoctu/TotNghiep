var api_fileuploader_logo;
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
            {"data": "device"},
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
                targets: [1, 4, 5, 6],
                class: 'text-center'
            },
			{
				orderable: false,
				targets: [-1],
				class: 'text-center'
			}
		]
    });
    
    $('#category_id', '#failure_id', 'line_id', 'area_id', 'device_id').select2({
        minimumResultsForSearch: Infinity,
        allowClear: true
    });
    

    if(typeof api_fileuploader_logo !== 'undefined') {
        api_fileuploader_logo.reset();
        api_fileuploader_logo.destroy();
    }
    fileuploader('input#logo');

    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_category"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var description = '';
            if(item.description != null && item.description != ''){
                description = ' ('+item.description+')';
            }
            var option = new Option(item.name+description , item.id, false, false);'('+item.description+')'
            $('#category_id').append(option);
        })
    });
    
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_line"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var description = '';
            if(item.description != null && item.description != ''){
                description = ' ('+item.description+')';
            }
            var option = new Option(item.name+description , item.id, false, false);'('+item.description+')'
            $('#line_id').append(option);
        })
    });

    $(document).on('click', '#addNotification', function (e) {
		e.preventDefault();
        $('#NotificationForm')[0].reset();
        var lang = $(this).attr('data-lang');
        ClearFormNotificationAdd(lang, 'add');
		$('#modal-notification-add').modal('show');
    });

    $(document).on('click', '.table-dynamic-location .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormNotification(lang, 'edit');
        UpdateNotification(id, lang);
    });
});

var fileuploader = function (element) {
    if($(element).length > 0) {
        $(element).fileuploader({
            limit: 1,
            fileMaxSize: 3,
            extensions: ['jpg', 'jpeg', 'png'],
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
                    });
                    $('#SettingForm').find('button:button').prop('disabled', $(this).serialize() == $(this).data('serialized'));
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
        api_fileuploader_logo = $.fileuploader.getInstance('input#logo');
        // api_fileuploader_cover = $.fileuploader.getInstance('input#img_cover');
        // api_fileuploader_background = $.fileuploader.getInstance('input#img_background');
    } 
}

var ClearFormNotificationAdd = function(lang, type) {
    $('#NotificationForm').parsley().reset();
    if(typeof api_fileuploader_logo !== 'undefined') {
        api_fileuploader_logo.reset();
        api_fileuploader_logo.destroy();
    }
    fileuploader('input#logo');
    $('#modal-notification-add #lang').val(lang);
    $('#modal-notification-add #category_id').val('').trigger('change.select2');
    $('#modal-notification-add #failure_id').val('').trigger('change.select2');
    $('#modal-notification-add #line_id').val('').trigger('change.select2');
    $('#modal-notification-add #area_id').val('').trigger('change.select2');
    $('#modal-notification-add #device_id').val('').trigger('change.select2');

    $('#modal-notification-add #ttlModal').html('Create Notification');
    $('#modal-notification-add #action').val('insert');
    $('#NotificationForm').each(function() {
        $(this).data('serialized', $(this).serialize())
    });

    $('#modal-notification-add').find('button.btn-primary').prop('disabled', true);
};
