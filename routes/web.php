<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Admin\AdminController@admin_login')->name('login');
Route::post('/login', 'Admin\AdminController@admin_login_action')->name('admin.login.action');
Route::get('/logout', 'Admin\AdminController@logout')->name('home.logout');
Route::post('changepassword', 'Admin\AdminController@change_pass')->name('admin.changepassword.action');
Route::get('/error', 'Admin\AdminController@admin_error')->name('admin.error');
//After login
Route::group(['prefix' => 'home', 'middleware' => 'auth.api'], function () {
    Route::group(['prefix' => 'ajax'], function () {
        // AJAX

        //category
        Route::get('ajax_category', 'Admin\AdminController@admin_category_ajax')->name('admin.notify.category.ajax');
        Route::post('ajax_category', 'Admin\AdminController@admin_post_category_ajax')->name('admin.post.notify.category.ajax');

        //failure mode
        Route::get('ajax_fail_mode', 'Admin\AdminController@admin_fail_mode_ajax')->name('admin.notify.fail.mode.ajax');
        Route::post('ajax_fail_mode', 'Admin\AdminController@admin_post_fail_mode_ajax')->name('admin.post.notify.fail.mode.ajax');

        //failure mode detail
        // Route::get('ajax_fail_mode_detail', 'Admin\AdminController@admin_fail_mode_detail_ajax')->name('admin.notify.fail.mode.detail.ajax');
        // Route::post('ajax_fail_mode_detail', 'Admin\AdminController@admin_post_fail_mode_detail_ajax')->name('admin.post.notify.fail.mode.detail.ajax');

        //line
        Route::get('ajax_line', 'Admin\AdminController@admin_line_ajax')->name('admin.notify.line.ajax');
        Route::post('ajax_line', 'Admin\AdminController@admin_post_line_ajax')->name('admin.post.notify.line.ajax');

        //Area
        Route::get('ajax_area', 'Admin\AdminController@admin_area_ajax')->name('admin.notify.area.ajax');
        Route::post('ajax_area', 'Admin\AdminController@admin_post_area_ajax')->name('admin.post.notify.area.ajax');

        //Class
        Route::get('ajax_device', 'Admin\AdminController@admin_device_ajax')->name('admin.notify.device.ajax');
        Route::post('ajax_device', 'Admin\AdminController@admin_post_device_ajax')->name('admin.post.notify.device.ajax');

        //User
        Route::get('ajax_user', 'Admin\AdminController@admin_user_ajax')->name('admin.notify.user.ajax');
        Route::post('ajax_user', 'Admin\AdminController@admin_post_user_ajax')->name('admin.post.notify.user.ajax');

        //role
        Route::get('ajax_get_permission', 'Admin\AdminController@get_permission')->name('admin.get.permission.ajax');
        Route::get('ajax_role', 'Admin\AdminController@admin_role_ajax')->name('admin.notify.role.ajax');
        Route::post('ajax_role', 'Admin\AdminController@admin_post_role_ajax')->name('admin.post.notify.role.ajax');

        //User
        Route::get('ajax_setting', 'Admin\AdminController@admin_setting_ajax')->name('admin.setting.ajax');
        Route::post('ajax_setting', 'Admin\AdminController@admin_post_setting_ajax')->name('admin.post.setting.ajax');

        //Notification
        Route::get('ajax_notification', 'Admin\AdminController@admin_notification_ajax')->name('admin.notification.ajax');
        Route::post('ajax_notification_add', 'Admin\AdminController@admin_post_notification_add_ajax')->name('admin.post.notification.add.ajax');
        Route::post('ajax_notification_update', 'Admin\AdminController@admin_post_notification_update_ajax')->name('admin.post.notification.update.ajax');

        //Logtime
        Route::get('ajax_logtime', 'Admin\AdminController@admin_logtime_ajax')->name('admin.logtime.ajax');
        Route::get('exportlogtime', 'Admin\AdminController@exportlogtime')->name('admin.export.logtime');

        //Report
        Route::get('ajax_report_user', 'Admin\AdminController@report_user')->name('admin.report.user');
        Route::get('ajax_report_performance', 'Admin\AdminController@report_performance')->name('admin.report.performance');
    });
    Route::group(['prefix' => 'action'], function () {
        // View
        Route::get('index', 'Admin\AdminController@index')->name('home.index');
        Route::get('category','Admin\AdminController@admin_category')->name('admin.failure.category')->middleware('permission:admin_category');
        Route::get('fail_mode','Admin\AdminController@admin_fail_mode')->name('admin.failure.mode')->middleware('permission:admin_failure');
        // Route::get('fail_mode_detail','Admin\AdminController@admin_fail_mode_detail')->name('admin.failure.mode.detail')->middleware('permission:admin_failure_detail');
        Route::get('area','Admin\AdminController@admin_area')->name('admin.area')->middleware('permission:admin_area');
        Route::get('device','Admin\AdminController@admin_device')->name('admin.device')->middleware('permission:admin_machine');
        Route::get('line','Admin\AdminController@admin_line')->name('admin.line')->middleware('permission:admin_line');
        Route::get('report','Admin\AdminController@admin_report')->name('admin.page.report')->middleware('permission:admin_report');
        Route::get('user','Admin\AdminController@admin_user')->name('admin.user')->middleware('permission:admin_user');
        Route::get('notification','Admin\AdminController@admin_notification')->name('admin.notification')->middleware('permission:admin_notification');
        Route::get('role','Admin\AdminController@admin_role')->name('admin.role')->middleware('permission:admin_role');
        Route::get('setting','Admin\AdminController@admin_setting')->name('admin.setting')->middleware('permission:admin_setting');
        Route::get('logtime','Admin\AdminController@admin_logtime')->name('admin.logtime')->middleware('permission:admin_logtime');

        Route::get('reportnew','Admin\AdminController@admin_report_new')->name('admin.page.report.new')->middleware('permission:admin_report');
    });
});
