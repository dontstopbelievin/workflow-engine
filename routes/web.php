<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/role-register', 'Admin\DashboardController@registered');
    Route::get('/user-edit/{id}', 'Admin\DashboardController@registeredit');
    Route::put('/role-register-update/{id}', 'Admin\DashboardController@registerupdate');
    Route::delete('/user-delete/{id}', 'Admin\DashboardController@registerdelete');


    Route::get('/roles', 'RoleController@index');
    Route::get('/role/{id}', 'RoleController@view');
    Route::get('/roles/create', 'RoleController@create');
    Route::post('/roles/create', 'RoleController@store');
    Route::get('/role-edit/{id}', 'RoleController@edit');
    Route::put('/role-update/{id}', 'RoleController@update');
    Route::delete('/role-delete/{id}', 'RoleController@delete');

    Route::get('/manual', 'FieldValueController@index');
    Route::get('/manual/create', 'FieldValueController@create');
    Route::post('/manual/create', 'FieldValueController@store');
    Route::get('/manual-edit/{id}', 'FieldValueController@edit');
    Route::put('/manual-update/{id}', 'FieldValueController@update');
    Route::delete('/manual-delete/{id}', 'FieldValueController@delete');

    Route::get('/process', 'ProcessController@index');
    Route::get('/process/create', 'ProcessController@create');

    

});
