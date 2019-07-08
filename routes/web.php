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

        //Major
        Route::get('ajax_major', 'Admin\AdminController@admin_major_ajax')->name('admin.notify.major.ajax');
        Route::post('ajax_major', 'Admin\AdminController@admin_post_major_ajax')->name('admin.post.notify.major.ajax');

        //Course
        Route::get('ajax_course', 'Admin\AdminController@admin_course_ajax')->name('admin.notify.course.ajax');
        Route::post('ajax_course', 'Admin\AdminController@admin_post_course_ajax')->name('admin.post.notify.course.ajax');
    });
    Route::group(['prefix' => 'action'], function () {
        // View
        Route::get('index', 'Admin\AdminController@index')->name('home.index');
        Route::get('category','Admin\AdminController@admin_category')->name('admin.failure.category')->middleware('permission:admin_category');
        Route::get('fail_mode','Admin\AdminController@admin_fail_mode')->name('admin.failure.mode')->middleware('permission:admin_failure');
        // Route::get('fail_mode_detail','Admin\AdminController@admin_fail_mode_detail')->name('admin.failure.mode.detail')->middleware('permission:admin_failure_detail');
        Route::get('course','Admin\AdminController@admin_course')->name('admin.school.course')->middleware('permission:admin_course');
        Route::get('machine','Admin\AdminController@admin_class')->name('admin.school.class')->middleware('permission:admin_class');
        Route::get('major','Admin\AdminController@admin_major')->name('admin.school.major')->middleware('permission:admin_major');
        Route::get('report','Admin\AdminController@admin_report')->name('admin.page.report')->middleware('permission:admin_report');
        Route::get('setting','Admin\AdminController@admin_setting')->name('admin.setting.general')->middleware('permission:admin_setting');
        Route::get('graduation','Admin\AdminController@admin_graduation')->name('admin.graduation')->middleware('permission:admin_graduation');
    });
});
