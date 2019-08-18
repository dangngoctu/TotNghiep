var table_dynamic_user, table_dynamic_log, majorId_filter, api_fileuploader;

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
            $('#line_id_filter').append(option);
        })
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
    $('#line_id_filter, #role').select2({
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
        ClearFormUser(lang, 'add');
        $('#modal-user').modal('show');
    });

    $('#line_id_filter').on("select2:select", function (e) {
        var data_major_filter = e.params.data;
        majorId_filter = data_major_filter.id;
        loadDataTable(majorId_filter);
    }).on('select2:unselect', function (e) {
        loadDataTable('');
    });
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

var loadDataTable = function (majorId, courseId) {
    if ($.fn.DataTable.isDataTable('.table-dynamic-user')) {
        $('.table-dynamic-user').DataTable().destroy();
        $('.table-dynamic-user tbody').empty();
    }
    table_dynamic_user = $('.table-dynamic-user').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": base_admin+"/home/ajax/ajax_user?majorId="+majorId,
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
    $('#modal-user #machine_id').val('').trigger('change.select2');
    if (type == "add") {
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
