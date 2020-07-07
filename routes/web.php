<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\FieldValue;
use App\Template;
use App\Process;
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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/dashboard', 'Admin\DashboardController@index');

    Route::get('/role-register', 'Admin\DashboardController@registered');
    Route::get('/user-edit/{user}', 'Admin\DashboardController@registeredit');
    Route::put('/role-register-update/{user}', 'Admin\DashboardController@registerupdate');
    Route::delete('/user-delete/{user}', 'Admin\DashboardController@registerdelete');


    Route::get('/roles', 'RoleController@index');
    Route::get('/role/{role}', 'RoleController@view');
    Route::get('/roles/create', 'RoleController@create');
    Route::post('/roles/create', 'RoleController@store');
    Route::get('/role-edit/{role}', 'RoleController@edit');
    Route::put('/role-update/{role}', 'RoleController@update');
    Route::delete('/role-delete/{role}', 'RoleController@delete');
    Route::post('/roles/search', 'RoleController@search');

    Route::get('/routes', 'RouteController@index');
    Route::get('/route/{id}', 'RouteController@view');
    Route::get('/routes/create', 'RouteController@create');
    Route::post('/routes/create', 'RouteController@store');
    Route::get('/route-edit/{id}', 'RouteController@edit');
    Route::put('/route-update/{id}', 'RouteController@update');
    Route::delete('/route-delete/{id}', 'RouteController@delete');


    Route::get('/templates', 'TemplateController@index');
    Route::get('/templates/create', 'TemplateController@create');
    Route::post('/templates/create', 'TemplateController@store');
    Route::get('/template-edit/{template}', 'TemplateController@edit');
    Route::put('/template-update/{template}', 'TemplateController@update');
    Route::delete('/template-delete/{template}', 'TemplateController@delete');

    Route::get('/manual', 'FieldValueController@index');
    Route::get('/manual/create', 'FieldValueController@create');
    Route::post('/manual/create', 'FieldValueController@store');
    Route::get('/manual-edit/{id}', 'FieldValueController@edit');
    Route::put('/manual-update/{id}', 'FieldValueController@update');
    Route::delete('/manual-delete/{id}', 'FieldValueController@delete');

    Route::get('/process', 'ProcessController@index');
    Route::get('/process/create', 'ProcessController@create');
    Route::post('/process/create', 'ProcessController@store');
    Route::get('/process/fields', 'ProcessController@getfields');
    Route::post('/process/save-fields', 'ProcessController@savefields');

    
    View::composer(['*'], function($view) {
        $usersCount = count(User::active()->get());
        $rolesCount = count(Role::all());
        $fieldsCount = count(FieldValue::all());
        $templatesCount = count(Template::all());
        $processesCount = count(Process::all());
        $view->with(compact('usersCount', 'rolesCount','fieldsCount', 'templatesCount','processesCount'));
    });

});
