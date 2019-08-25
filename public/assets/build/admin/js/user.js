var table_dynamic_user, table_dynamic_log, line_filter, api_fileuploader;

$(function(){
    'use strict';
    loadDataTable('');
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_line"
    }).then(function (data) {
        $.map(data.data, function (item) {
            var option = new Option(item.name, item.id, false, false);
            $('#line_id_filter, #line_select').append(option);
        })
    }).then(function () {
        $('#line_id_filter').val('').trigger('change.select2');
    });
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: base_admin + "/home/ajax/ajax_role"
    }).then(function (data) {
        $.map(data.data, function (item, index) {
            $('#role').append('<option label="Select role"></option>')
            var option = new Option(item.name, item.id, false, false);
            $('#role').append(option);
        })
    })

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $('#line_id_filter, #role, #select_area, #select_line').select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
   
    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'dd/mm/yy'
    });

    $(document).on('click', '.table-dynamic-user .table-action-edit', function (e) {
        var id = $(this).attr('data-id');
        var lang = $(this).attr('data-lang');
        ClearFormUser(lang, 'edit');
        UpdateUser(id, lang);
    });

    $(document).on('click', '#addUser', function (e) {
        e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormUser(lang, 'insert');
        $('#modal-user').modal('show');
    });

    $('#line_id_filter').on("select2:select", function (e) {
        var data_line_filter = e.params.data;
        line_filter = data_line_filter.id;
        loadDataTable(line_filter);
    }).on('select2:unselect', function (e) {
        loadDataTable('');
    });

    //Add User
    $(document).on('click', '#addUser', function (e) {
        e.preventDefault();
        var lang = $(this).attr('data-lang');
        ClearFormUser(lang, 'insert');
        $('#blockLine, #blockLine, #blockArea').addClass('d-none');
        $('#line_select, #area_select').parents('.row').addClass('d-none');
        $('#modal-user').modal('show');
    });

    //Delete User
    $(document).on('click', '.table-dynamic-user .table-action-delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#confirm-delete-modal #id').val(id);
        $('#confirm-delete-modal #action').val('delete_user');
        $('#confirm-delete-modal #txt_confirm').html('Do you want to delete this user?');
        $('#confirm-delete-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    $('#confirm-delete-modal').on('click', '#confirm-delete', function (e) {
        var id = $('#confirm-delete-modal #id').val();
        var action =  $('#confirm-delete-modal #action').val();
        if(action == 'delete_user') {
            ActionUser(id, 'delete', table_dynamic_user);
        }
        if(action == 'deactive_user') {
            ActionUser(id, 'deactive', table_dynamic_user);
        }
        if(action == 'active_user') {
            ActionUser(id, 'active', table_dynamic_user);
        }
        
        
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
            UserFormSubmit(table_dynamic_user);
        }
    });

    //Modal Add User
    $('#role').select2({
        minimumResultsForSearch: Infinity
    }).on('select2:select', function (e) {
        var data = e.params.data;
        switchRole(data.id);
    });
    $('#areaMachine').select2();
    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'dd/mm/yy'
    });
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

    $('#line_select').on("change", function (e) {
        if($('#role').val() == 4){
            $('#UserForm #area_select').prop('required',true);
            $('#area_select').parents('.row').removeClass('d-none');
            var data = $('#line_select').val();
            switchFunction('#area_select', data);
        }
        $('#UserForm').parsley().reset();
    }).on('select2:unselect', function (e) {
        $('#area_select').parents('.row').addClass('d-none');
        $('#UserForm').parsley().reset();
        $('#area_select').empty();
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
                    $('#modal-user').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
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

var loadDataTable = function (lineId, courseId) {
    if ($.fn.DataTable.isDataTable('.table-dynamic-user')) {
        $('.table-dynamic-user').DataTable().destroy();
        $('.table-dynamic-user tbody').empty();
    }
    table_dynamic_user = $('.table-dynamic-user').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_user?lineId="+lineId,
        "responsive": true,
        "scrollX": true,
        "ordering": false,
        "pagingType": "full_numbers",
        "language": {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
		"columns": [
			{"data": "id"},
            {"data": "name"},
            {"data": "email", "searchable": false},
            {"data": "major", "searchable": false},
            {"data": "phone", "searchable": false},
			{"data": "role", "searchable": false},
			{"data": "action", "searchable": false}
		],
		"columnDefs": [
            {
				targets: [0],
				class: 'text-center wd-100'
			},
            {
                targets: [1],
                class: 'multi-line wd-500'
            },
            {
                targets: [2],
                class: 'text-center wd-150'
            },
            {
                targets: [4],
                class: 'text-center wd-150'
            },
            {
                targets: [5],
                class: 'text-center wd-150'
            },
            {
                targets: [3],
                class: 'multi-line wd-500 text-center'
            },
			{
				targets: [-1],
				class: 'text-center wd-150'
			}
		]
    });
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
};

var ClearFormUser = function(lang, type) {
    $('#UserForm')[0].reset();
    $('#UserForm').parsley().reset();
    if(typeof api_fileuploader !== 'undefined') {
        api_fileuploader.reset();
        api_fileuploader.destroy();
    }
    fileuploader();
    $('#modal-user #lang').val(lang);
    $('#modal-user #major_id').val('').trigger('change.select2');
    $('#modal-user #area_select').val('').trigger('change.select2');
    $('#modal-user #line_select').val('').trigger('change.select2');
    
    if (type == "insert") {
        $('#modal-user #ttlModal').html('Add user');
        $('#modal-user #action').val('insert');
        $('.block-pass-word').addClass('d-none');
        machine_id = '';
        $('#UserForm').each(function() {
            $(this).data('serialized', $(this).serialize())
        });
    } else {
        $('#modal-user #ttlModal').html('Update user');
        $('.block-pass-word').addClass('d-none');
        $('#modal-user #action').val('update');
    }
    $('#modal-user').find('button.btn-primary').prop('disabled', true);

    $('#UserForm').on('change input', function() {
        $('#modal-user').find('button.btn-primary').prop('disabled', $(this).serialize() == $(this).data('serialized'));
    });
};

var UpdateUser = function(id, lang) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_user?lang=" + lang + "&id=" + id,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                $('#modal-user #id').val(response.data.id);
                $('#modal-user #name').val(response.data.name);
                $('#modal-user #email').val(response.data.email);
                $('#modal-user #phone').val(response.data.phone);
                $('#modal-user input[name="pass"][value="2"]:radio').prop( "checked", true );
                $('.block-pass-word').removeClass('d-none');
                $('#UserForm #password').prop('required',false);
                $('#UserForm #repassword').prop('required',false);
                $('#UserForm #password').parents('.row').find('.tx-danger').addClass('d-none');
                $('#UserForm #repassword').parents('.row').find('.tx-danger').addClass('d-none');
                $('#UserForm').parsley().reset();
                if(response.data.avatar != null) {
                    api_fileuploader.append([{
                        name: (response.data.avatar).substring((response.data.avatar).lastIndexOf('/')+1),
                        type: 'image/png',
                        file: base_admin+'/'+response.data.avatar,
                        data: {
                            url: base_admin+'/'+response.data.avatar,
                            thumbnail: base_admin+'/'+response.data.avatar
                        }
                    }]);
                    api_fileuploader.updateFileList();
                }
                if(response.data.dob !== null){
                    $('#modal-user #dob').val(moment(response.data.dob).format('DD/MM/YYYY'));
                } else {
                    $('#modal-user #dob').val('');
                }
                $('#modal-user').modal('show');
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
            $('#UserForm').each(function() {
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

var UserFormSubmit = function(table) {
    $('#btnUser').attr('disabled', true);
    var form_data = new FormData($('#UserForm')[0]);
    var fileList = Object.keys(api_fileuploader.getFileList()).length;
    form_data.append('fileList', fileList);
    $.ajax({
        url: base_admin + "/home/ajax/ajax_user",
        type: "post",
        data: form_data,
        cache:false,
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        dataType: "json",
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
                $('#modal-user').modal('hide');
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

var switchRole = function (id) {
    switch (id)
    {
        case "2":
            $('#blockLine').addClass('d-none');
            $('#blockArea').addClass('d-none');
            $('#UserForm #line_select').prop('required',false);
            $('#UserForm #area_select').prop('required',false);
            $('#UserForm').parsley().reset();
            $('#line_select, #area_selected').empty();
            line_id = '', area_id = '';
            break;
        case "3":
            $('#blockLine').removeClass('d-none');
            $('#blockArea').addClass('d-none');
            $('#line_select').parents('.row').removeClass('d-none');
            if ($('#UserForm #line_select').data("select2")) {
                $('#UserForm #line_select').select2('destroy');
                $('#UserForm #line_select').select2({
                    allowClear: true,
                    minimumResultsForSearch: Infinity
                });
            }
            $('#UserForm #line_select').prop('required',true);
            $('#UserForm #area_select').prop('required',false);
            $('#UserForm').parsley().reset();
            $('#UserForm #line_select').val('').trigger('change.select2');
            $('#line_select, #area_selected').empty();
            line_id = '', area_id = '';
            switchFunction('#line_select', line_id);
            break;
        case "4":
            $('#blockLine').removeClass('d-none');
            $('#line_select').parents('.row').removeClass('d-none');
            if ($('#UserForm #line_select').data("select2")) {
                $('#UserForm #line_select').select2('destroy');
                $('#UserForm #line_select').select2({
                    allowClear: true,
                    minimumResultsForSearch: Infinity
                });
            }
            if ($('#UserForm #area_select').data("select2")) {
                $('#UserForm #area_select').select2('destroy');
                $('#UserForm #area_select').select2({
                    allowClear: true,
                    minimumResultsForSearch: Infinity
                });
            }
            $('#UserForm #line_select').prop('required',true);
            $('#UserForm #area_select').prop('required',true);
            $('#UserForm').parsley().reset();
            $('#UserForm #line_select').val('').trigger('change.select2');
            $('#UserForm #area_select').val('').trigger('change.select2');
            $('#line_select, #area_selected').empty();
            line_id = '', area_id = '';
            switchFunction('#line_select', line_id);
            break;
    }
};

var switchFunction = function (ele, data) {
    $(ele).empty();
    switch (ele) {
        case '#area_select':
            $('#blockArea').removeClass('d-none');
            $('#area_select').parents('.row').removeClass('d-none');
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: base_admin + "/home/ajax/ajax_area?lineId=" + data
            }).then(function (data) {
                $('#area_select').append("<option>Select area</option>");
                $.map(data.data, function (item) {
                    var option = new Option(item.m_area_translations.name, item.id, false, false);
                    $('#area_select').append(option);
                })
            });
            break;
        case '#line_select':
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: base_admin + "/home/ajax/ajax_line"
            }).then(function (data) {
                $('#line_select').append("<option>Select line</option>");
                $.map(data.data, function (item) {
                    var option = new Option(item.name, item.id, false, false);
                    $('#line_select').append(option);
                })
            });
            break;
    }
};

var ActionUser = function(id, action, table) {
    $.ajax({
        url: base_admin + "/home/ajax/ajax_user?action="+action+"&id=" + id,
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
