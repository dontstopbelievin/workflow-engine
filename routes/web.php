<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Template;
use App\Process;
use App\Handbook;
use App\Application;
use App\CityManagement;
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

Route::get('/list', function () {
    return view('list.list');
});


Auth::routes();

Route::get('services', 'ApplicationController@service')->name('applications.service');
Route::get('index/{process}', 'ApplicationController@index')->name('applications.index');
Route::get('application-view/{process_id}/{application_id}', 'ApplicationController@view')->name('applications.view');


Route::get('applications-create/{process}', 'ApplicationController@create')->name('applications.create');
Route::post('applications/store', 'ApplicationController@store')->name('applications.store');
Route::post('applications/approve/{application_id}', 'ApplicationController@approve')->name('applications.approve');
Route::post('applications/sendToSubRoute/{application_id}', 'ApplicationController@sendToSubRoute')->name('applications.sendToSubRoute');
Route::post('applications/backToMainOrg/{application_id}', 'ApplicationController@backToMainOrg')->name('applications.backToMainOrg');

Route::post('applications/toCitizen/{application_id}', 'ApplicationController@toCitizen')->name('applications.toCitizen');

Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/dictionary', 'DictionaryController@index')->name('dictionary');
    Route::post('/dictionary/create', 'DictionaryController@create')->name('dictionary.create');
    Route::get('/dictionary/createFields', 'DictionaryController@createFields')->name('dictionary.createFields');
    Route::post('/dictionary/saveToTable', 'DictionaryController@saveToTable')->name('dictionary.saveToTable');


    Route::get('/list', 'ListController@index');
    Route::post('/list', 'ListController@create');
    Route::post('/list/delete', 'ListController@delete');
    Route::post('/list/update', 'ListController@update');
    Route::get('/list/search', 'ListController@search');

    Route::get('/cities', 'CityManagementController@index')->name('city.index');
    Route::post('/city', 'CityManagementController@create');
    Route::post('/city/delete', 'CityManagementController@delete');
    Route::post('/city/update', 'CityManagementController@update');
    Route::get('/city/search', 'CityManagementController@search');

    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard.index');

    Route::get('role-register', 'Admin\DashboardController@registered')->name('user-role.register');
    Route::get('user-edit/{user}', 'Admin\DashboardController@registeredit')->name('user-role.edit');
    Route::put('role-register-update/{user}', 'Admin\DashboardController@registerupdate')->name('user-role.update');
    Route::delete('user-delete/{user}', 'Admin\DashboardController@registerdelete')->name('user-role.delete');


    Route::get('roles', 'RoleController@index')->name('role.index');
    Route::get('role/{role}', 'RoleController@view')->name('role.view');
    Route::get('roles/create', 'RoleController@create')->name('role.create');
    Route::post('roles/create', 'RoleController@store')->name('role.store');
    Route::get('role-edit/{role}', 'RoleController@edit')->name('role.edit');
    Route::put('role-update/{role}', 'RoleController@update')->name('role.update');
    Route::delete('role-delete/{role}', 'RoleController@delete')->name('role.delete');
    Route::post('roles/search', 'RoleController@search')->name('role.search');

    
    Route::get('routes', 'RouteController@index')->name('route.index');
    Route::get('route/{id}', 'RouteController@view')->name('route.view');
    Route::get('routes/create', 'RouteController@create')->name('route.create');
    Route::post('routes/create', 'RouteController@store')->name('route.store');
    Route::get('route-edit/{id}', 'RouteController@edit')->name('route.edit');
    Route::put('route-update/{id}', 'RouteController@update')->name('route.update');
    Route::delete('route-delete/{id}', 'RouteController@delete')->name('route.delete');


    Route::get('templates', 'TemplateController@index')->name('template.index');
    Route::get('templates/create', 'TemplateController@create')->name('template.create');
    Route::post('templates/create', 'TemplateController@store')->name('template.store');
    Route::get('template-edit/{template}', 'TemplateController@edit')->name('template.edit');
    Route::put('template-update/{template}', 'TemplateController@update')->name('template.update');
    Route::delete('template-delete/{template}', 'TemplateController@delete')->name('template.delete');

    Route::get('manual', 'HandbookController@index')->name('manual.index');;

    Route::get('processes', 'ProcessController@index')->name('processes.index');
    Route::get('processes/{process}', 'ProcessController@view')->name('processes.view');
    Route::get('process/create', 'ProcessController@create')->name('processes.create');
    Route::post('processes', 'ProcessController@store')->name('processes.store');
    Route::post('add-sub-roles', 'ProcessController@addSubRoles')->name('processes.addSubRoles');
    Route::post('add-organization/{process}', 'ProcessController@addOrganization')->name('processes.addOrganization');
    Route::get('processes-edit/{process}', 'ProcessController@edit')->name('processes.edit');
    Route::put('processes-update/{process}', 'ProcessController@update')->name('processes.update');
    Route::post('create-process-table/{process}', 'ProcessController@createProcessTable')->name('processes.createProcessTable');
    Route::post('process-add-role/{process}', 'ProcessController@addRole')->name('processes.addRole');
    Route::delete('process-delete/{process}', 'ProcessController@delete')->name('processes.delete');

    
    View::composer(['*'], function($view) {
        $usersCount = count(User::active()->get());
        $rolesCount = count(Role::all());
        $templatesCount = count(Template::all());
        $processesCount = count(Process::all());
        $cityManagementCount = count(CityManagement::all());
        $applicationsCount = count(CityManagement::all());
        $handbook = new Handbook;
        $handbookCount = count($handbook->getTableColumns());
        $view->with(compact('usersCount', 'rolesCount','fieldsCount', 'templatesCount','processesCount','handbookCount','cityManagementCount','applicationsCount'));
    });

});
