<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Template;
use App\Process;
use App\Application;
use App\CityManagement;
use App\Dictionary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

Auth::routes();

Route::get('/policy', function () {return view('policy');});
Route::get('/list', function () {return view('list.list');});
Route::get('/verification/{p}/{a}/{t}', 'ApplicationController@verification');
Route::prefix('testpage')->group(function () {
    Route::get('/view/{id}', 'EdsSignController@viewsign');
    Route::post('/xmlVerification', 'EdsSignController@signVerify');
});

Route::middleware(['guest'])->group(function () {

    Route::post('loginwithecp/bar', 'EdsSignController@loginByCert');
    Route::get('/loginwithecp', function () {return view('auth.loginwithecp');});
    Route::get('/dataformater','AuctionController@dataFormater');
    Route::get('/test', 'IntegrationController@test');

    Route::prefix('integrations')->group(function () {

        Route::get('/{type}', 'IntegrationController@index');

        Route::prefix('shep')->group(function () {
            Route::post('/async-request-receiver', 'IntegrationController@async');
            Route::post('/sync-request-receiver', 'IntegrationController@sync');
            Route::post('/receiver', 'IntegrationController@receive');
        });
    });

});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'ApplicationController@incoming');
    Route::post('agreement_accept', 'ApplicationController@acceptAgreement');

    Route::prefix('password')->group(function () {
        Route::get('/expired', 'Auth\ExpiredPasswordController@expired');
        Route::post('/post_expired', 'Auth\ExpiredPasswordController@postExpired');
    });

    Route::prefix('docs')->group(function () {
        Route::get('/', 'ApplicationController@service');
        Route::get('index/{process}', 'ApplicationController@index');
        Route::post('/search', 'ApplicationController@search');
        Route::post('/store', 'ApplicationController@store');
        Route::post('/approve', 'ApplicationController@approve');
        Route::post('/reject', 'ApplicationController@reject');
        Route::post('/revision', 'ApplicationController@revision');
        Route::post('/approveReject', 'ApplicationController@approveReject');
        Route::post('/toCitizen/{application_id}', 'ApplicationController@toCitizen');
        Route::get('/download/{file}', 'ApplicationController@download');
        Route::get('/view/{process_id}/{application_id}', 'ApplicationController@view');
        Route::get('/create/{process}', 'ApplicationController@create');
        Route::prefix('services')->group(function () {
          Route::prefix('incoming')->group(function () {
            Route::get('/', 'ApplicationController@incoming');
            Route::get('/view/{process_id}/{application_id}', 'ApplicationController@view');
          });
          Route::prefix('outgoing')->group(function () {
            Route::get('/', 'ApplicationController@outgoing');
            Route::get('/view/{process_id}/{application_id}', 'ApplicationController@view');
          });
          Route::prefix('mydocs')->group(function () {
            Route::get('/', 'ApplicationController@mydocs');
            Route::get('/view/{process_id}/{application_id}', 'ApplicationController@view');
          });
          Route::prefix('archive')->group(function () {
            Route::get('/', 'ApplicationController@archive');
            Route::get('/view/{process_id}/{application_id}', 'ApplicationController@view');
          });
          Route::get('/drafts', 'ApplicationController@drafts');
        });
    });

    Route::prefix('user')->group(function () {
        Route::get('/personal_area', 'UserController@index');
        Route::get('/filter', 'UserController@filter');
        Route::get('/edit/{user}', 'UserController@edit');
        Route::put('/update/{user}', 'UserController@update');
    });
});

Route::group(['prefix' => '/admin', 'middleware' => ['admin', 'auth']], function () {

    Route::get('send', 'HomeController@sendNotification');
    Route::get('logs', 'ProcessController@logs');

    Route::prefix('dictionary')->group(function () {
        Route::get('/', 'DictionaryController@index');
        Route::post('/create', 'DictionaryController@create');
        Route::get('/createFields', 'DictionaryController@createFields');
        Route::post('/saveToTable', 'DictionaryController@saveToTable');
    });

    Route::prefix('list')->group(function () {
        Route::get('/', 'ListController@index');
        Route::post('/', 'ListController@create');
        Route::post('/delete', 'ListController@delete');
        Route::post('/update', 'ListController@update');
        Route::get('/search', 'ListController@search');
    });

    Route::prefix('city')->group(function () {
        Route::get('/index', 'CityManagementController@index');
        Route::post('/', 'CityManagementController@create');
        Route::post('/delete', 'CityManagementController@delete');
        Route::post('/update', 'CityManagementController@update');
        Route::get('/search', 'CityManagementController@search');
    });

    Route::prefix('user_role')->group(function () {
        Route::get('/dashboard', 'Admin\DashboardController@index');
        Route::get('/register', 'Admin\DashboardController@registered');
        Route::get('/edit/{user}', 'Admin\DashboardController@registeredit');
        Route::put('/update/{user}', 'Admin\DashboardController@registerupdate');
        Route::delete('/delete/{user}', 'Admin\DashboardController@registerdelete');
    });

    Route::prefix('role')->group(function () {
        Route::get('/', 'RoleController@index');
        Route::get('/view/{role}', 'RoleController@view');
        Route::get('/create', 'RoleController@create');
        Route::post('/create', 'RoleController@store');
        Route::get('/edit/{role}', 'RoleController@edit');
        Route::put('/update/{role}', 'RoleController@update');
        Route::delete('/delete/{role}', 'RoleController@delete');
        Route::post('/search', 'RoleController@search');
    });

    Route::prefix('route')->group(function () {
        Route::get('/', 'RouteController@index');
        Route::get('/{id}', 'RouteController@view');
        Route::get('/create', 'RouteController@create');
        Route::post('/store', 'RouteController@store');
        Route::get('/edit/{id}', 'RouteController@edit');
        Route::put('/update/{id}', 'RouteController@update');
        Route::delete('/delete/{id}', 'RouteController@delete');
    });

    Route::prefix('template')->group(function () {
        Route::get('/', 'TemplateController@index');
        Route::get('/create', 'TemplateController@create');
        Route::post('/store', 'TemplateController@store');
        Route::get('/edit/{template}', 'TemplateController@edit');
        Route::post('/update/{id}', 'TemplateController@update');
        Route::post('/delete/{id}', 'TemplateController@delete');
    });

    Route::prefix('template_field')->group(function () {
        Route::get('/create/{template}', 'TemplateFieldController@create');
        Route::post('/store', 'TemplateFieldController@store');
        Route::get('/def_val/create/{field_id}', 'TemplateFieldController@def_value');
        Route::post('/def_val/store', 'TemplateFieldController@def_value_store');
        Route::post('/def_val/delete/{id}', 'TemplateFieldController@delete');
    });

    Route::prefix('auction')->group(function () {
        Route::get('/', 'AuctionController@index');
        Route::get('/create', 'AuctionController@create');
        Route::get('/view', 'AuctionController@view');
        Route::post('/store', 'AuctionController@store');
        Route::get('/send/{id}', 'AuctionController@sendToEgkn');
    });

    Route::prefix('egknservice')->group(function () {
        Route::get('/', 'EgknServiceController@index');
        Route::get('/view', 'EgknServiceController@view');
        Route::get('/load', 'EgknServiceController@load');
        Route::get('/status', 'EgknServiceController@status');
        Route::get('/act', 'EgknServiceController@act');
    });

    Route::prefix('select_options')->group(function () {
        Route::get('/create', 'SelectOptionController@create');
        Route::post('/store', 'SelectOptionController@store');
        Route::post('/delete', 'SelectOptionController@delete');
        Route::post('/update', 'SelectOptionController@update');
    });

    Route::prefix('process')->group(function () {
        Route::get('/', 'ProcessController@index');
        Route::get('/create', 'ProcessController@create');
        Route::get('/view/{process}', 'ProcessController@view');
        Route::post('/store', 'ProcessController@store');
        Route::post('/add_organization/{process}', 'ProcessController@addOrganization');
        Route::get('/edit/{process}', 'ProcessController@edit')->name('process/edit');
        Route::put('/update/{process}', 'ProcessController@update');
        Route::post('/create_process_table/{process}', 'ProcessController@createProcessTable');
        Route::post('/add_role/{process}', 'ProcessController@addRole');
        Route::post('/add_sub_role/{process}', 'ProcessController@add_sub_role');
        Route::delete('/delete/{process}', 'ProcessController@delete');
    });

    Route::prefix('process_role')->group(function () {
        Route::post('/update/{process}', 'ProcessController@update_process_role');
        Route::post('/delete/{process}', 'ProcessController@delete_process_role');
    });

    View::composer(['*'], function($view) {
        $usersCount = count(User::active()->get());
        $rolesCount = count(Role::all());
        $templatesCount = count(Template::all());
        $processesCount = count(Process::all());
        $dictionariesCount = count(Dictionary::all());
        $cityManagementCount = count(CityManagement::all());
        $view->with(compact('usersCount', 'rolesCount', 'dictionariesCount','templatesCount','processesCount','cityManagementCount'));
    });
});
