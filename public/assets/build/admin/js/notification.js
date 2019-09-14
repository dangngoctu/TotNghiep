var api_fileuploader_logo;
var areaId, deviceId;
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
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#category_id, #line_id, #failure_id, #area_id, #device_id, #status').select2({
        minimumResultsForSearch: Infinity,
        allowClear: true
    });
    $(document).on('click', '#btnNotificationAdd', function (e) {
        e.preventDefault();
        $('#NotificationForm').submit();
    });

    $("#NotificationForm").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            NotificationFormSubmit(table_dynamic_notification);
        }
    });

    $(document).on('click', '#btnNotificationUpdate', function (e) {
        e.preventDefault();
        $('#reason').val($('#modal-notification-update #comment_review').summernote('code'));
        $('#NotificationFormUpdate').submit();
    });

    $("#NotificationFormUpdate").on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()){
            NotificationFormUpdateSubmit(table_dynamic_notification);
        }
    });

    $('#line_id').on("select2:select", function (e) {
        $('#blockArea').removeClass('d-none');
        $('#NotificationForm #area_id').prop('required',true);
        $('#NotificationForm').parsley().reset();
        var data = e.params.data;
        switchFunction('#area_id', data.id);
    }).on('select2:unselect', function (e) {
        $('#blockArea').addClass('d-none');
        $('#blockDevice').addClass('d-none');
        $('#NotificationForm #area_id').prop('required',false);
        $('#NotificationForm #device_id').prop('required',false);
        $('#NotificationForm').parsley().reset();
        $('#area_id').empty();
        $('#device_id').empty();
    });

    $('#area_id').on("select2:select", function (e) {
        $('#blockDevice').removeClass('d-none');
        $('#NotificationForm #device_id').prop('required',true);
        $('#NotificationForm').parsley().reset();
        var data = e.params.data;
        switchFunction('#device_id', data.id);
    }).on('select2:unselect', function (e) {
        $('#blockDevice').addClass('d-none');
        $('#NotificationForm #area_id').prop('required',false);
        $('#NotificationForm #device_id').prop('required',false);
        $('#NotificationForm').parsley().reset();
        $('#area_id').empty();
        $('#device_id').empty();
    });

    $('#category_id').on("select2:select", function (e) {
        $('#blockFailure').removeClass('d-none');
        $('#NotificationForm #failure_id').prop('required',true);
        $('#NotificationForm').parsley().reset();
        var data = e.params.data;
        switchFunction('#failure_id', data.id);
    }).on('select2:unselect', function (e) {
        $('#blockFailure').addClass('d-none');
        $('#NotificationForm #failure_id').prop('required',false);
        $('#NotificationForm').parsley().reset();
        $('#failure_id').empty();
    });

    $('.summernote').summernote({
        dialogsInBody: true,
        height: 300
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

    $(document).on('click', '.table-dynamic-notification .table-action-delete', function (e) {
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
        DeleteNotification(id, table_dynamic_notification);
    });

    $(document).on('click', '#addNotification', function (e) {
		e.preventDefault();
        $('#NotificationForm')[0].reset();
        var lang = $(this).attr('data-lang');
        ClearFormNotificationAdd(lang, 'add');
		$('#modal-notification-add').modal('show');
    });

    $(document).on('click', '.table-dynamic-notification .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormNotificationInsert(lang, 'edit');
        UpdateNotification(id, lang);
    });

    $('#NotificationForm').on('change input', function() {
        $('#modal-notification-add').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
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

var UpdateNotification = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_notification?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                $('#modal-notification-update #id').val(response.data.id);
                $('#modal-notification-update #creater').val(response.data.m_user.name);
                $('#modal-notification-update #category').val(response.data.m_category.m_categories_translations.name);
                $('#modal-notification-update #failure').val(response.data.m_failure_mode.m_failure_mode_translations.name);
                $('#modal-notification-update #device').val(response.data.m_device.m_device_translations.name);
                $('#modal-notification-update #comment').val(response.data.comment);
                if(response.data.status != 1){
                    $('#modal-notification-update #comment_review').summernote('code',response.data.submit_comment);
                    $('.summernote').summernote('disable');
                    $('#modal-notification-update #status').val(response.data.status).trigger('change.select2');
                    $('#modal-notification-update #status').prop('disabled', true);
                    $('.btn-submit-noti').addClass('d-none')
                } else {
                    $('.btn-submit-noti').removeClass('d-none')
                }
                $('#modal-notification-update').modal('show');
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
            $('#NotificationFormUpdate').each(function() {
                $(this).data('serialized', $(this).serialize())
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: response.msg
            });
        }
    });
};

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
var line_id = '', area_id = '', device_id = '';
var ClearFormNotificationInsert = function(lang, type) {
    $('#NotificationFormUpdate').parsley().reset();
    if(typeof api_fileuploader_logo !== 'undefined') {
        api_fileuploader_logo.reset();
        api_fileuploader_logo.destroy();
    }
    fileuploader('input#logo');
    $('#modal-notification-update #comment_review').summernote('code','');
    $('.summernote').summernote('enable');
    $('#modal-notification-update #status').val('').trigger('change.select2');
    $('#modal-notification-update #status').prop('disabled', false);
    $('#modal-notification-update #lang').val(lang);
    $('#modal-notification-update #ttlModal').html('Confirm Notification');
    $('#modal-notification-update #action').val('update');
};

var switchFunction = function (ele, data) {
    $(ele).empty();
    switch (ele) {
        case '#area_id':
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: base_admin + "/home/ajax/ajax_area?lineId=" + data
            }).then(function (data) {
                $('#area_id').append("<option>Select area</option>");
                $.map(data.data, function (item) {
                    var option = new Option(item.m_area_translations.name, item.id, false, false);
                    $('#area_id').append(option);
                })
            });
            break;
        case '#device_id':
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: base_admin + "/home/ajax/ajax_device?areaId=" + data
            }).then(function (data) {
                $('#device_id').append("<option>Select device</option>");
                $.map(data.data, function (item) {
                    var option = new Option(item.m_device_translations.name, item.id, false, false);
                    $('#device_id').append(option);
                })
            });
            break;
        case '#failure_id':
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: base_admin + "/home/ajax/ajax_fail_mode?categoryId=" + data
            }).then(function (data) {
                $('#failure_id').append("<option>Select failure</option>");
                $.map(data, function (item) {
                    var option = new Option(item.m_failure_mode_translations.name, item.id, false, false);
                    $('#failure_id').append(option);
                })
            });
            break;
    }
};

var NotificationFormUpdateSubmit = function(table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_notification_update",
        type: "post",
        data: $('#NotificationFormUpdate').serialize(),
        success: function(response) {
            if (response.code == '200') {
                Lobibox.notify("success", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
                table.ajax.reload(null, true);
                $('#modal-notification-update').modal('hide');
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: 'There was an error during processing'
            });
        }
    });
};

var NotificationFormSubmit = function(table){
    var form_data = new FormData($('#NotificationForm')[0]);
    var fileListLogo = Object.keys(api_fileuploader_logo.getFileList()).length;
    form_data.append('fileListLogo', fileListLogo);
    // var fileListCover = Object.keys(api_fileuploader_cover.getFileList()).length;
    // form_data.append('fileListCover', fileListCover);
    // var fileListBackground = Object.keys(api_fileuploader_background.getFileList()).length;
    // form_data.append('fileListBackground', fileListBackground);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
		cache:false,
		contentType: false,
		enctype: 'multipart/form-data',
		processData: false,
		dataType: "json",
		type: "post",
		url: base_admin + "/home/ajax/ajax_notification_add",
        success: function(response) {
            if (response.code == '200') {
                Lobibox.notify("success", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
                table.ajax.reload(null, true);
                $('#modal-notification-add').modal('hide');
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: 'There was an error during processing'
            });
        }
    });
};

var DeleteNotification = function(id, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_notification_add?action=delete&id=" + id,
        type: "post",
        success: function(response) {
            if (response.code == '200') {
                Lobibox.notify("success", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
                table.ajax.reload(null, true);
            } else {
                Lobibox.notify("warning", {
                    title: 'Notification',
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    icon: false,
                    sound: false,
                    msg: response.msg
                });
            }
            // $('#confirm-delete-modal #confirm-delete').button('reset');
            $('#confirm-delete-modal').modal('hide');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Lobibox.notify("warning", {
                title: 'Notification',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                icon: false,
                sound: false,
                msg: 'There was an error during processing'
            });
            // $('#confirm-delete-modal #confirm-delete').button('reset');
            $('#confirm-delete-modal').modal('hide');
        }
    });
};
