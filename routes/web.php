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
    });
    Route::group(['prefix' => 'action'], function () {
        // AJAX
        Route::get('index', 'Admin\AdminController@index')->name('home.index');
    });
});
