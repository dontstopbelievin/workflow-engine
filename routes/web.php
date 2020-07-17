<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\FieldValue;
use App\Template;
use App\Process;
use App\Handbook;
use Carbon\Carbon;

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

Route::get('services', 'ApplicationController@service')->name('applications.service');
Route::get('index/{process}', 'ApplicationController@index')->name('applications.index');
Route::get('view/{application}', 'ApplicationController@view')->name('applications.view');
Route::get('applications-create/{process}', 'ApplicationController@create')->name('applications.create');
Route::post('applications/store', 'ApplicationController@store')->name('applications.store');

Route::group(['middleware' => ['admin', 'auth']], function () {

    Route::get('dashboard', 'Admin\DashboardController@index');

    Route::get('role-register', 'Admin\DashboardController@registered');
    Route::get('user-edit/{user}', 'Admin\DashboardController@registeredit');
    Route::put('role-register-update/{user}', 'Admin\DashboardController@registerupdate');
    Route::delete('user-delete/{user}', 'Admin\DashboardController@registerdelete');


    Route::get('roles', 'RoleController@index');
    Route::get('role/{role}', 'RoleController@view');
    Route::get('roles/create', 'RoleController@create');
    Route::post('roles/create', 'RoleController@store');
    Route::get('role-edit/{role}', 'RoleController@edit');
    Route::put('role-update/{role}', 'RoleController@update');
    Route::delete('role-delete/{role}', 'RoleController@delete');
    Route::post('roles/search', 'RoleController@search');

    Route::get('routes', 'RouteController@index');
    Route::get('route/{id}', 'RouteController@view');
    Route::get('routes/create', 'RouteController@create');
    Route::post('routes/create', 'RouteController@store');
    Route::get('route-edit/{id}', 'RouteController@edit');
    Route::put('route-update/{id}', 'RouteController@update');
    Route::delete('route-delete/{id}', 'RouteController@delete');


    Route::get('templates', 'TemplateController@index');
    Route::get('templates/create', 'TemplateController@create');
    Route::post('templates/create', 'TemplateController@store');
    Route::get('template-edit/{template}', 'TemplateController@edit');
    Route::put('template-update/{template}', 'TemplateController@update');
    Route::delete('template-delete/{template}', 'TemplateController@delete');

    Route::get('manual', 'FieldValueController@index');
    Route::get('manual/create', 'FieldValueController@create');
    Route::post('manual/create', 'FieldValueController@store');
    Route::get('manual-edit/{id}', 'FieldValueController@edit');
    Route::put('manual-update/{id}', 'FieldValueController@update');
    Route::delete('manual-delete/{id}', 'FieldValueController@delete');

    Route::get('processes', 'ProcessController@index')->name('processes.index');
    Route::get('processes/{process}', 'ProcessController@view')->name('processes.view');
    Route::get('process/create', 'ProcessController@create')->name('processes.create');
    Route::post('processes', 'ProcessController@store')->name('processes.store');
    Route::get('processes-edit/{process}', 'ProcessController@add')->name('processes.edit');
    Route::put('processes-update/{process}', 'ProcessController@update')->name('processes.update');
    Route::post('process-save-fields/{process}', 'ProcessController@savefields')->name('processes.savefields');
    Route::post('process-add-role/{process}', 'ProcessController@addRole')->name('processes.addrole');
    Route::delete('process-delete/{process}', 'ProcessController@delete')->name('processes.delete');

    
    View::composer(['*'], function($view) {
        $usersCount = count(User::active()->get());
        $rolesCount = count(Role::all());
        $fieldsCount = count(FieldValue::all());
        $templatesCount = count(Template::all());
        $processesCount = count(Process::all());
        $handbook = new Handbook;
        $handbookCount = count($handbook->getTableColumns());
        $view->with(compact('usersCount', 'rolesCount','fieldsCount', 'templatesCount','processesCount','handbookCount'));
    });

});
